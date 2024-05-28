<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V3\Public\Billing\Shares\Sell;

use App\Dto\Models\Billing\SellDto;
use App\Dto\Models\Billing\PaymentDto;
use App\Enums\Billing\Payment\TypeEnum as PaymentTypeEnum;
use App\Enums\Billing\Wallet\TypeEnum as WalletTypeEnum;
use App\Exceptions\Pipelines\V1\Billing\WithdrawalNotPossibleException;
use App\Http\Requests\Api\V3\Public\Billing\Shares\Sell\InitSellRequest;
use App\Services\Utils\ApollopaymentApiService;
use App\Dto\Utils\ApollopaymentApi\GetCommissionWithdrawalDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Services\Api\V1\Billing\PaymentService;
use App\Enums\Billing\Sell\SellPeriodEnum;
use Carbon\Carbon;
use App\Services\Api\V1\Billing\WalletService;
use App\Services\Api\V1\Billing\TokenService;
use App\Enums\Billing\Withdrawal\MethodEnum  as WithdrawalMethodEnum;
use App\Enums\Billing\Withdrawal\StatusEnum  as WithdrawalStatusEnum;
use App\Services\Api\V3\Billing\SellService;

final class SellController extends Controller
{
    public function __construct(
        private readonly PaymentService $service,
        private readonly WalletService $walletService,
        private readonly TokenService $tokenService,
        private readonly SellService $sellService,
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

    function calculateValues($sumUserRealPayments, $sumUserPayments, $sumUserDividends, $lastUserPayment, $service): array {
        $amount = $sumUserPayments;
        $for = 0;
        $earlyTerminationFee = 0;
        $transactionFee = 0;
        $allPaid = 0;
        $apolloService = [];
        if ($amount > 0) {
            $now = Carbon::now();
            $days = $now->diffInDays($lastUserPayment?->getCreatedAt());
            if ($days == 0) {
                $for = $sumUserRealPayments;
                $apolloService = $this->getFees($for, $service);
                $transactionFee = $apolloService['response']['blockchainFeeUSD'] + $apolloService['response']['serviceFeeUSD'];
            } elseif ($days >= 1 && $days < 32) {
                $for = $sumUserRealPayments;
                $earlyTerminationFee = ($for * 10) / 100;
                $apolloService = $this->getFees($for, $service);
                $transactionFee = $apolloService['response']['blockchainFeeUSD'] + $apolloService['response']['serviceFeeUSD'];
                $allPaid = $sumUserDividends;
            } elseif ($days >= 32 && $days < 1095) {
                $for = $sumUserRealPayments;
                $earlyTerminationFee = ($for * 20) / 100;
                $apolloService = $this->getFees($for, $service);
                $transactionFee = $apolloService['response']['blockchainFeeUSD'] + $apolloService['response']['serviceFeeUSD'];
                $allPaid = $sumUserDividends;
            } elseif ($days >= 1095) {
                $for = $sumUserPayments;
                $apolloService = $this->getFees($for, $service);
                $transactionFee = $apolloService['response']['blockchainFeeUSD'] + $apolloService['response']['serviceFeeUSD'];
            }
            $for -= ($earlyTerminationFee + $transactionFee + $allPaid);
            return [$amount, $for, $earlyTerminationFee, $transactionFee, $allPaid, $apolloService];
        } else {
            return [$amount, $for, $earlyTerminationFee, $transactionFee, $allPaid, $apolloService];
        }
    }

    function getPeriod($lastUserPayment): string {
        $now = Carbon::now();
        $days = $now->diffInDays($lastUserPayment?->getCreatedAt());
        $period = null;
        if ($days == 0) {
            $period = SellPeriodEnum::UP_TO_1_DAY->value;
        } elseif ($days >= 1 && $days < 32) {
            $period = SellPeriodEnum::FROM_1_DAY_TO_32_DAYS->value;
        } elseif ($days >= 32 && $days < 1095) {
            $period = SellPeriodEnum::FROM_32_DAY_TO_1095_DAYS->value;
        } elseif ($days >= 1095) {
            $period = SellPeriodEnum::MORE_THAN_1095_DAYS->value;
        }
        return $period;
    }

    public function valuate(InitSellRequest $request, ApollopaymentApiService $service): JsonResponse
    {
        $accountUuid = $request->payload()->getUuid();
        [$sumUserRealPayments, $sumUserPayments, $sumUserDividends, $lastUserPayment] = $this->service->getDataForValuateSell($accountUuid);
        [$amount, $for, $earlyTerminationFee, $transactionFee, $allPaid, $apolloService] = $this->calculateValues($sumUserRealPayments, $sumUserPayments, $sumUserDividends, $lastUserPayment, $service);
        return response()->json([
            'data' => [
                'uuid' => $accountUuid,
                "amount" => $amount,
                'for' => $for,
                'real_amount' => $sumUserRealPayments,
                'early_termination_fee' => $earlyTerminationFee,
                'transaction_fee' => $transactionFee,
                'all_paid'  => $allPaid,
                'apollo_payment_commissions' => $apolloService,
            ],
        ]);
    }

    public function confirm(InitSellRequest $request, ApollopaymentApiService $service): JsonResponse
    {
        $accountUuid = $request->payload()->getUuid();
        [$referralAmount, $bonusAmount, $dividendsAmount, $sumUserRealPayments, $sumUserPayments, $sumUserDividends, $lastUserPayment] = $this->service->getDataForConfirmSell($accountUuid);
        [$amount, $for, $earlyTerminationFee, $transactionFee, $allPaid, $apolloService] = $this->calculateValues($sumUserRealPayments, $sumUserPayments, $sumUserDividends, $lastUserPayment, $service);
        $period = $this->getPeriod($lastUserPayment);
        $destination = $request->get("destination") ?? '';
        $isDestinationValid = $service->checkBlockchainAddress($destination, 'polygon');
        $acceptEarlyTerminationFee = $request->get("accept_early_termination_fee");
        if ($isDestinationValid && $isDestinationValid['response']['isValid'] && $acceptEarlyTerminationFee) {
            $bonusWallet = $this->walletService->get([
                'account_uuid' => $accountUuid,
                'type' => WalletTypeEnum::BONUS->value
            ]);
            $referralWallet = $this->walletService->get([
                'account_uuid' => $accountUuid,
                'type' => WalletTypeEnum::REFERRAL->value
            ]);
            $dividendsWallet = $this->walletService->get([
                'account_uuid' => $accountUuid,
                'type' => WalletTypeEnum::DIVIDENDS->value
            ]);
            $btcPrice = $this->tokenService->getBitcoinAmount();
            $payment = $this->service->create(PaymentDto::fromArray([
                'account_uuid' => $accountUuid,
                    'referral_wallet_uuid' => $referralWallet?->getUuid() ?? null,
                    'bonus_wallet_uuid' => $bonusWallet?->getUuid() ?? null,
                    'dividend_wallet_uuid' => $dividendsWallet?->getUuid() ?? null,
                    'referral_amount' => $referralAmount,
                    'bonus_amount' => $bonusAmount,
                    'dividend_amount' => $dividendsAmount,
                    'real_amount' => $sumUserRealPayments,
                    'total_amount_btc' => 1 / $btcPrice * ($referralAmount + $bonusAmount + $dividendsAmount + $sumUserRealPayments),
                    'btc_price' => $btcPrice,
                    'type' => PaymentTypeEnum::SELL->value,
                    'withdraw_method' => WithdrawalMethodEnum::POLYGON_USDT->value,
            ]));
            $this->sellService->create(SellDto::fromArray([
                'account_uuid' => $accountUuid,
                'payment_uuid' => $payment->getUuid(),
                'status' => WithdrawalStatusEnum::INIT->value,
                'period' => $period,
                'method' => WithdrawalMethodEnum::POLYGON_USDT->value,
                'destination' => $destination,
                'value' => $for,
                'real_amount' => $sumUserRealPayments,
                'termination_fee' => $earlyTerminationFee,
                'transaction_fee' => $transactionFee,
                'return_all_paid' => $allPaid,
            ]));
            return response()->json([
                'data' => [
                    'success' => true,
                    'uuid' => $accountUuid,
                    "amount" => $for,
                    'destination' => $destination,
                    'accept_early_termination_fee' => $acceptEarlyTerminationFee,
                    'is_destination_valid' => $isDestinationValid,
                ],
            ]);
        } else {
            return response()->json([
                'data' => [
                    'success' => false,
                    'uuid' => $accountUuid,
                    'destination' => $destination,
                    'is_accept_early_termination_fee' => $acceptEarlyTerminationFee,
                    'is_destination_valid' => $isDestinationValid['response']['isValid'],
                ],
            ]);
        }
    }
}
