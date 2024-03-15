<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Statistic;

use App\Enums\Billing\Payment\TypeEnum;
use App\Models\Billing\Payment;
use App\Services\Api\V1\Billing\PaymentService;
use App\Services\Api\V1\Billing\TokenService;
use App\Services\Api\V1\Fund\ShareholderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;

final class MainController extends Controller
{
    public function __construct(
        private readonly TokenService $tokenService,
        private readonly ShareholderService $shareholderService,
        private readonly PaymentService $paymentService,
    ) {
    }

    public function main(): JsonResponse
    {
        $btcPrice = $this->tokenService->getBitcoinAmount();

        $shareholdersAll = $this->shareholderService->getCount([]);
        $shareholdersToday = $this->shareholderService->getCount([
            ['created_at', '>=', Carbon::now()->setTime(0, 0)->toDateTimeString()],
        ]);

        $sizeUsd = (float) Payment::query()
            ->selectRaw('SUM(COALESCE(referral_amount,0)+COALESCE(bonus_amount,0)+COALESCE(dividend_amount,0)+COALESCE(real_amount,0)) AS total_amount')
            ->where([
                'type' => TypeEnum::CREDIT_FROM_CLIENT->value,
                ['real_amount', '!=', null]
            ])
            ->value('total_amount');

        $averageSizeUsd = $sizeUsd / $shareholdersAll;
        $averageSizeBtc = (float) bcmul(
            bcdiv(
                '1',
                (string) $btcPrice,
                8
            ),
            (string) $averageSizeUsd,
            8
        );

        $dividendsTotalUsd = $this->paymentService->getTotalDividends();
        $dividendsTotalBtc = $this->paymentService->getTotalDividendsBtc();

        return response()->json([
            'data' => [
                'average_size_usd' => $averageSizeUsd ?? 0,
                'average_size_btc' => $averageSizeBtc ?? 0,
                'shareholders_count' => $shareholdersAll ?? 0,
                'shareholders_today_count' => $shareholdersToday ?? 0,
                'dividends_earned_usd' => $dividendsTotalUsd ?? 0,
                'dividends_earned_btc' => $dividendsTotalBtc ?? 0,
            ],
        ]);
    }
}
