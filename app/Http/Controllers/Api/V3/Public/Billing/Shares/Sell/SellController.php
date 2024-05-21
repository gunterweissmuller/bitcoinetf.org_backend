<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V3\Public\Billing\Shares\Sell;

use App\Http\Requests\Api\V3\Public\Billing\Shares\Sell\InitSellRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Services\Api\V1\Billing\PaymentService;
use App\Enums\Billing\Sell\SellPeriodEnum;
use Carbon\Carbon;

final class SellController extends Controller
{
    public function __construct(
        private readonly PaymentService $service
    ) {
    }

    public function init(InitSellRequest $request): JsonResponse
    {
        $accountUuid = $request->payload()->getUuid();
        $lastUserPayment = $this->service->getLastUserPayment($accountUuid);
        $sumUserPayments = $this->service->getSumPayments($accountUuid);
        $sumUserRealPayments = $this->service->getSumRealPayments($accountUuid);
        $sumUserDividends = $this->service->getTotalDividends($accountUuid);
        $now = Carbon::now();
        $days = $now->diffInDays($lastUserPayment?->getCreatedAt());
        $needAccept = true;
        $type = null;
        $value = 0;
        $earlyTerminationFee = 0;
        if ($days == 0) {
            $needAccept = false;
            $type = SellPeriodEnum::UP_TO_1_DAY->value;
            $value = $sumUserRealPayments;
        } elseif ($days >= 1 && $days < 32) {
            $type = SellPeriodEnum::FROM_1_DAY_TO_32_DAYS->value;
            $earlyTerminationFee = ($sumUserRealPayments * 10) / 100;
            $value = $sumUserRealPayments - $earlyTerminationFee - $sumUserDividends;
        } elseif ($days >= 32 && $days < 1095) {
            $type = SellPeriodEnum::FROM_32_DAY_TO_1095_DAYS->value;
            $earlyTerminationFee = ($sumUserRealPayments * 20) / 100;
            $value = $sumUserRealPayments - $earlyTerminationFee - $sumUserDividends;
        } elseif ($days >= 1095) {
            $needAccept = false;
            $type = SellPeriodEnum::MORE_THAN_1095_DAYS->value;
            $value = $sumUserPayments;
        }
        return response()->json([
            'data' => [
                'uuid' => $accountUuid,
                'need_accept_early_termination_fee' => $needAccept,
                'shares' => $sumUserPayments,
                'real_payments' => $sumUserRealPayments,
                'early_termination_fee' => $earlyTerminationFee,
                'dividends' => $sumUserDividends,
                'value' => $value,
                'type' => $type,
                'created_at' => $lastUserPayment?->getCreatedAt(),
            ],
        ]);
    }
}
