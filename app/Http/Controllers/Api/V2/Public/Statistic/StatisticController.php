<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V2\Public\Statistic;

use App\Enums\Billing\Payment\TypeEnum;
use App\Enums\Settings\Global\SymbolEnum;
use App\Models\Billing\Payment;
use App\Services\Api\V1\Billing\PaymentService;
use App\Services\Api\V1\Billing\TokenService;
use App\Services\Api\V1\Fund\ShareholderService;
use App\Services\Api\V1\Settings\GlobalService;
use App\Services\Api\V1\Statistic\DailyAumService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use App\Models\Statistic\DailyAssets;

final class StatisticController extends Controller
{
    public function __construct(
        private readonly TokenService       $tokenService,
        private readonly ShareholderService $shareholderService,
        private readonly PaymentService     $paymentService,
        private readonly DailyAumService    $dailyAumService,
        private readonly GlobalService      $globalService,
    )
    {
    }

    public function general(Request $request): JsonResponse
    {
        $btcPrice = $this->tokenService->getBitcoinAmount();

        $shareholdersAll = $this->shareholderService->getCount([]);
        $shareholdersToday = $this->shareholderService->getCount([
            ['created_at', '>=', Carbon::now()->setTime(0, 0)->toDateTimeString()],
        ]);

        $sizeUsd = (float)Payment::query()
            ->selectRaw('SUM(COALESCE(referral_amount,0)+COALESCE(bonus_amount,0)+COALESCE(dividend_amount,0)+COALESCE(real_amount,0)) AS total_amount')
            ->where([
                'type' => TypeEnum::CREDIT_FROM_CLIENT->value,
                ['real_amount', '!=', null]
            ])
            ->value('total_amount');

        $averageSizeUsd = $sizeUsd / $shareholdersAll;
        $averageSizeBtc = (float)bcmul(
            bcdiv(
                '1',
                (string)$btcPrice,
                8
            ),
            (string)$averageSizeUsd,
            8
        );

        //aum usd
        $aumUsdBtcDayParam = (int)$request->input('aum_usd_daily_filter');

        if ($aumUsdBtcDayParam > 0) {
            $aumUsdFilterData = [
                ['created_at', '=', Carbon::now()->subDays($aumUsdBtcDayParam - 1)->startOfDay()->toDateString()],
            ];
        } else {
            $aumUsdFilterData = [
                ['created_at', '=', Carbon::now()->endOfDay()->toDateString()],
            ];
        }

        //dividends
        $dividendsTotalUsd = $this->paymentService->getTotalDividends();

        $dividendsTotalBtcDayParam = (int)$request->input('dividends_earned_btc_daily_filter');
        $dividendsTotalBtcFilterData = [];

        if ($dividendsTotalBtcDayParam > 0) {
            $startOfDay = Carbon::now()->subDays($dividendsTotalBtcDayParam - 1)->startOfDay()->toDateTimeString();
            $endOfDay = Carbon::now()->endOfDay()->toDateTimeString();
            $dividendsTotalBtcFilterData = [
                ['created_at', '>=', $startOfDay],
                ['created_at', '<=', $endOfDay],
            ];
        }

        $accountUuid = null;
        if (!!$request->input('current_user_info')) {
            $accountUuid = $request->payload()->getUuid();
        }

        $dividendsTotalBtc = $this->paymentService->getTotalDividendsBtc($accountUuid, $dividendsTotalBtcFilterData);

        $trcBonusReduced = null;
        if ($trcBonus = $this->globalService->get([
            'symbol' => SymbolEnum::TRC_BONUS->value,
        ])) {
            $trcBonusReduced = Carbon::parse($trcBonus->getUpdatedAt())->setTime(0, 1)->toDateTimeString();
        }

        return response()->json([
            'data' => [
                'btc_price' => $btcPrice,
                'aum_usd' => $this->dailyAumService->get($aumUsdFilterData)->getAmount() ?? null,
                'minimal_apy' => $this->globalService->getMinimumApyValue(),
                'projected_apy' => $this->globalService->getProjectedApyValue(),
                'average_size_usd' => $averageSizeUsd ?? 0,
                'average_size_btc' => $averageSizeBtc ?? 0,
                'shareholders_count' => $shareholdersAll ?? 0,
                'shareholders_today_count' => $shareholdersToday ?? 0,
                'dividends_earned_usd' => $dividendsTotalUsd ?? 0,
                'dividends_earned_btc' => $dividendsTotalBtc ?? 0,
                'trc_bonus' => [
                    'percent' => $this->globalService->getTrcBonus() ? (float)bcmul(
                        (string)$this->globalService->getTrcBonus(),
                        '100',
                        2
                    ) : 0,
                    'reduced' => $trcBonusReduced,
                    'decrease' => $this->globalService->getTrcBonusDecrease()
                        ? Carbon::parse($this->globalService->getTrcBonusDecrease())->setTime(0, 1)->toDateTimeString()
                        : null,
                ],
            ],
        ]);
    }

    public function flow(Request $request): JsonResponse
    {
        $flowInit = [
            ['value' => 0],
            ['is_growth' => false,'half_year_change_size_usd' => 0, 'percent' => 0],
            ['x0' => 0, 'y0' => 0],
            ['x1' => 0, 'y1' => 0],
            ['x2' => 0, 'y2' => 0],
        ];
        function sizeOn($date, $uuid):float|int {
            return (float) DailyAssets::query()
                ->where([
                    'asset_uuid' => $uuid,
                    ['created_at', '<=', $date]
                ])
                ->orderBy('created_at', 'desc')
                ->limit(1)
                ->value('amount');
        }
        $asset_uuid = request()->input('asset_uuid') ?? null;
        if ($asset_uuid) {
            $x0 = now()->subMonths(6)->format('M Y');
            $x1 = now()->subMonths(3)->format('M Y');
            $x2 = now()->format('M Y');
            $y0 = sizeOn(now()->subMonths(6)->startOfMonth()->toDateTimeString(), $asset_uuid);
            $y1 = sizeOn(now()->subMonths(3)->startOfMonth()->toDateTimeString(), $asset_uuid);
            $y2 = sizeOn(now()->subMonths(0)->startOfMonth()->toDateTimeString(), $asset_uuid);
            $change_size_usd = $y2 > $y0 ? $y2 - $y0 : $y0 - $y2;
            $change_base = min($y0, $y2)>0?min($y0, $y2):1;
            $flow = [
                ['value' => sizeOn(now()->toDateTimeString(), $asset_uuid) ?? 0],
                ['is_growth' => $y2 >= $y0,'half_year_change_size_usd' => $change_size_usd, 'percent' => $change_size_usd * 100 / $change_base],
                ['x0' => $x0, 'y0' => $y0],
                ['x1' => $x1, 'y1' => $y1],
                ['x2' => $x2, 'y2' => $y2],
            ];
            return response()->json([
                'data' => [
                    'asset_uuid' => $asset_uuid,
                    'flow' => $flow,
                ],
            ]);
        }
        return response()->json([
            'data' => [
                'asset_uuid' => $asset_uuid,
                'flow' => $flowInit,
            ],
        ]);
    }

}
