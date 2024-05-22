<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V3\Public\Billing\Shares\Sell;

use App\Exceptions\Pipelines\V1\Billing\WithdrawalNotPossibleException;
use App\Http\Requests\Api\V3\Public\Billing\Shares\Sell\InitSellRequest;
use App\Services\Utils\ApollopaymentApiService;
use App\Dto\Utils\ApollopaymentApi\GetCommissionWithdrawalDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Services\Api\V1\Billing\PaymentService;
use App\Enums\Billing\Sell\SellPeriodEnum;
use Carbon\Carbon;

final class SellController extends Controller
{
    public function __construct(
        private readonly PaymentService $service,
    ) {
    }

    public function init(InitSellRequest $request): JsonResponse
    {
        $accountUuid = $request->payload()->getUuid();
        [$sumUserRealPayments, $sumUserPayments, $sumUserDividends, $lastUserPayment] = $this->service->getDataForValuateSell($accountUuid);
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

    public function valuate(InitSellRequest $request, ApollopaymentApiService $service): JsonResponse
    {
        function getFees($amount, $service): array {
            try {
                $commissionWithdrawalDto = GetCommissionWithdrawalDto::fromArray([
                    'advancedBalanceId' => env('APOLLO_PAYMENT_ADVANCED_BALANCE_ID'),
                    'addressId' => env('APOLLO_PAYMENT_BASIC_WALLET_POLYGON_USDT_ADDRESS_ID'),
                    'amount' => $amount,
                ]);
                $commissionFor = $service->getCommissionWithdrawal($commissionWithdrawalDto);
                if ($commissionFor['success'] && $commissionFor['response']) {
                    return $commissionFor;
                } else {
                    throw new WithdrawalNotPossibleException('Apollo payment response is null');
                }
            } catch (\Exception $e) {
                throw new WithdrawalNotPossibleException($e->getMessage());
            }
        }
        $accountUuid = $request->payload()->getUuid();
        [$sumUserRealPayments, $sumUserPayments, $sumUserDividends, $lastUserPayment] = $this->service->getDataForValuateSell($accountUuid);
        $amount = $request->get("amount");
        $for = 0;
        $earlyTerminationFee = 0;
        $transactionFee = 0;
        $dividendsReturn = 0;
        $apolloService = [];
        if ($amount > 0 && $amount <= $sumUserPayments) {
            $amountPercent = ($amount * 100) / $sumUserPayments;
            $now = Carbon::now();
            $days = $now->diffInDays($lastUserPayment?->getCreatedAt());
            if ($days == 0) {
                $for = ($sumUserRealPayments / 100) * $amountPercent;
                $apolloService = getFees($for, $service);
                $transactionFee = $apolloService['response']['blockchainFeeUSD'] + $apolloService['response']['serviceFeeUSD'];
            } elseif ($days >= 1 && $days < 32) {
                $for = ($sumUserRealPayments / 100) * $amountPercent;
                $earlyTerminationFee =  ($for * 10) / 100;
                $apolloService = getFees($for, $service);
                $transactionFee = $apolloService['response']['blockchainFeeUSD'] + $apolloService['response']['serviceFeeUSD'];
                $dividendsReturn = ($sumUserDividends / 100) * $amountPercent;
            } elseif ($days >= 32 && $days < 1095) {
                $for = ($sumUserRealPayments / 100) * $amountPercent;
                $earlyTerminationFee =  ($for * 20) / 100;
                $apolloService = getFees($for, $service);
                $transactionFee = $apolloService['response']['blockchainFeeUSD'] + $apolloService['response']['serviceFeeUSD'];
                $dividendsReturn = ($sumUserDividends / 100) * $amountPercent;
            } elseif ($days >= 1095) {
                $for = ($sumUserPayments / 100) * $amountPercent;
                $apolloService = getFees($for, $service);
                $transactionFee = $apolloService['response']['blockchainFeeUSD'] + $apolloService['response']['serviceFeeUSD'];
            }
            $for -= ($earlyTerminationFee + $transactionFee + $dividendsReturn);
        }

        return response()->json([
            'data' => [
                'uuid' => $accountUuid,
                "amount" => $request->get("amount"),
                'for' => $for,
                'early_termination_fee' => $earlyTerminationFee,
                'transaction_fee' => $transactionFee,
                'response' => $apolloService,
            ],
        ]);
    }

    public function confirm(InitSellRequest $request, ApollopaymentApiService $service): JsonResponse
    {
        $accountUuid = $request->payload()->getUuid();
        $amount = $request->get("amount") ?? 0;
        $destination = $request->get("destination") ?? '0x';
        $acceptEarlyTerminationFee = $request->get("accept_early_termination_fee") ?? false;

        return response()->json([
            'data' => [
                'uuid' => $accountUuid,
                'success' => true,
                "amount" => $amount,
                'destination' => $destination,
                'accept_early_termination_fee' => $acceptEarlyTerminationFee,
            ],
        ]);
    }
}
