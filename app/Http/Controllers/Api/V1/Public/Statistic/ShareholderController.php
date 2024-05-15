<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Statistic;

use App\Enums\Billing\Payment\TypeEnum;
use App\Http\Requests\Api\V1\Public\Statistic\Shareholder\ListRequest;
use App\Models\Fund\Shareholder;
use App\Services\Api\V1\Fund\ShareholderService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\Api\V1\Users\AccountService;
use App\Enums\Users\Account\OrderTypeEnum;
use Illuminate\Support\Facades\Cache;
use App\Models\Billing\Payment;

final class ShareholderController extends Controller
{
    public function __construct(
        private readonly ShareholderService $shareholderService,
        private readonly AccountService $accountService,
    ) {
    }

    public function count(): JsonResponse
    {
        return response()->json([
            'data' => [
                'count' => $this->shareholderService->getCount([])
            ],
        ]);
    }

    public function top(ListRequest $request): JsonResponse
    {
        $shareholdersTop = $this->shareholderService->getTop($request->dto(), ['account_uuid', 'total_payments']);
        $accountsUuid = $shareholdersTop?->getCollection()?->pluck('account.uuid');
        $totalDividendsByAccounts = DB::table('billing.payments')
            ->selectRaw('account_uuid, SUM(dividend_amount)')
            ->where(['type' => TypeEnum::DEBIT_TO_CLIENT->value])
            ->whereIn('account_uuid', $accountsUuid)
            ->groupBy('account_uuid')
            ->get();

        // TODO: Костыль на total_dividends поздже поправить
        $shareholdersTop->through(function (Shareholder $value) use ($totalDividendsByAccounts) {
            $data = $value->toArray();
            $data['total_dividends'] = (float)$totalDividendsByAccounts->where('account_uuid', $data['account_uuid'])->value('sum');

            return $data;
        });

        return response()->json([
            'data' => $shareholdersTop,
        ]);
    }

    public function strategies(): JsonResponse
    {
        function customRound($num1, $num2):float|int {
            $total = $num1 + $num2 > 0 ? $num1 + $num2 : 1;
            if($num1 > $num2) {
                return floor($num1 * 100/ $total);
            } else {
                return ceil($num1 * 100/ $total);
            }
        }
        $countUsd = Cache::rememberForever('countUsd', function () {
            return $this->accountService->all(['order_type' => OrderTypeEnum::USDT->value])?->count() ?? 0;
        });
        $countBtc = Cache::rememberForever('countBtc', function () {
            return $this->accountService->all(['order_type' => OrderTypeEnum::BTC->value])?->count() ?? 0;
        });
        $percentUsd = customRound($countUsd, $countBtc);
        $percentBtc = customRound($countBtc, $countUsd);
        $strategies = [
            ['name' => 'Tether', 'percent' => $percentUsd, 'count' => $countUsd],
            ['name' => 'Bitcoin', 'percent' => $percentBtc, 'count' => $countBtc],
        ];
        return response()->json($strategies);
    }

    public function growth(): JsonResponse
    {
        function sizeUsd($date):float|int {
            return (float) Payment::query()
                ->selectRaw('SUM(COALESCE(referral_amount,0)+COALESCE(bonus_amount,0)+COALESCE(dividend_amount,0)+COALESCE(real_amount,0)) AS total_amount')
                ->where([
                    'type' => TypeEnum::CREDIT_FROM_CLIENT->value,
                    ['real_amount', '!=', null],
                    ['created_at', '<=', $date] // now()->subMonths($shift)->startOfMonth()->toDateTimeString()
                ])
                ->value('total_amount');
        }
        function countShareholders($shift, $shareholderService):float|int {
            return $shareholderService->getCount([
                ['created_at', '<=', now()->subMonths($shift)->startOfMonth()->toDateTimeString()],
            ]);
        }
        $x0 = now()->subMonths(6)->format('M Y');
        $x1 = now()->subMonths(3)->format('M Y');
        $x2 = now()->format('M Y');
        $y0 = $this->shareholderService->getCount([
            ['created_at', '<=', now()->subMonths(6)->startOfMonth()->toDateTimeString()],
        ]);
        $y1 = $this->shareholderService->getCount([
            ['created_at', '<=', now()->subMonths(3)->startOfMonth()->toDateTimeString()],
        ]);
        $y2 = $this->shareholderService->getCount([
            ['created_at', '<=', now()->subMonths(0)->startOfMonth()->toDateTimeString()],
        ]);
        $current_shareholders_count = $this->shareholderService->getCount([]);
        $is_growth = $y2 >= $y0;
        $size0 = sizeUsd(now()->subMonths(6)->startOfMonth()->toDateTimeString());
        $size2 = sizeUsd(now()->subMonths(0)->startOfMonth()->toDateTimeString());
        $change_size_usd = $size2 > $size0 ? $size2 - $size0 : $size0 - $size2;
        $change_base = min($size0, $size2);
        $growth = [
            ['shareholders' => $current_shareholders_count, 'aum_size_usd' => sizeUsd(now()->toDateTimeString())],
            ['is_growth' => $is_growth,'half_year_change_size_usd' => $change_size_usd, 'percent' => $change_size_usd * 100 / $change_base],
            ['x0' => $x0, 'y0' => $y0, 'aum_size_0' => $size0],
            ['x1' => $x1, 'y1' => $y1, 'aum_size_1' => sizeUsd(now()->subMonths(3)->startOfMonth()->toDateTimeString())],
            ['x2' => $x2, 'y2' => $y2, 'aum_size_2' => $size2],
        ];
        return response()->json($growth);
    }
}
