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
        $checkBalance = $this->service->checkBalance($accountUuid);
        if ($checkBalance) {
            $lastUserPayment = $this->service->getLastUserPayment($accountUuid);
            $period = $this->getPeriod($lastUserPayment);
            return response()->json([
                'data' => [
                    'period' => $period,
                    'created_at' => $lastUserPayment?->getCreatedAt(),
                ],
            ]);
        } else {
            return response()->json([
                'data' => [
                    'period' => null,
                    'created_at' => null,
                ],
            ]);
        }
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

    function calculateValues(
        $sumUserRealPayments,
        $sumUserPayments,
        $sumUserDividends,
        $lastUserPayment,
        $sumUserSells,
        $realAmountSell,
        $service,
        $btcPrice,
        $btcPriceLastUserPayment
    ): array {
        $amount = $sumUserPayments - $sumUserSells;
        $for = 0;
        $earlyTerminationFee = 0;
        $transactionFee = 0;
        $allPaid = 0;
        $exchangeRateDeduction = 0;
        $apolloService = [];
        if ($amount > 0) {
            $now = Carbon::now();
            $days = $now->diffInDays($lastUserPayment?->getCreatedAt());
            $for = $sumUserRealPayments - $realAmountSell;
            if ($btcPrice < $btcPriceLastUserPayment) {
                $exchangeRateDeduction = $for * (1 - ($btcPrice / $btcPriceLastUserPayment));
            }
            if ($days == 0) {
                $apolloService = $this->getFees($for, $service);
                $transactionFee = $apolloService['response']['blockchainFeeUSD'] + $apolloService['response']['serviceFeeUSD'];
            } elseif ($days >= 1 && $days < 1095) {
                $earlyTerminationFee = (($for * 30) / 100) + $exchangeRateDeduction;
                $apolloService = $this->getFees($for, $service);
                $transactionFee = $apolloService['response']['blockchainFeeUSD'] + $apolloService['response']['serviceFeeUSD'];
                $allPaid = $sumUserDividends;
            } elseif ($days >= 1095) {
                $for = $sumUserPayments - $sumUserSells;
                $apolloService = $this->getFees($for, $service);
                $transactionFee = $apolloService['response']['blockchainFeeUSD'] + $apolloService['response']['serviceFeeUSD'];
            }
            $for -= ($earlyTerminationFee + $transactionFee + $allPaid);
            return [$amount, $for, $earlyTerminationFee, $transactionFee, $allPaid, $apolloService, $exchangeRateDeduction];
        } else {
            return [$amount, $for, $earlyTerminationFee, $transactionFee, $allPaid, $apolloService, $exchangeRateDeduction];
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
        $btcPrice = $this->tokenService->getBitcoinAmount();
        [$sumUserRealPayments, $sumUserPayments, $sumUserDividends, $lastUserPayment, $sumUserSells, $realAmountSell] = $this->service->getDataForValuateSell($accountUuid);
        $btcPriceLastUserPayment = $lastUserPayment?->getBtcPrice();
        [
            $amount,
            $for,
            $earlyTerminationFee,
            $transactionFee,
            $allPaid,
            $apolloService,
            $exchangeRateDeduction
        ] = $this->calculateValues(
            $sumUserRealPayments,
            $sumUserPayments,
            $sumUserDividends,
            $lastUserPayment,
            $sumUserSells,
            $realAmountSell,
            $service,
            $btcPrice,
            $btcPriceLastUserPayment
        );
        $period = $this->getPeriod($lastUserPayment);
        return response()->json([
            'data' => [
                'uuid' => $accountUuid,
                'created_at' => $amount > 0 ? $lastUserPayment?->getCreatedAt() : null,
                'period' => $amount > 0 ? $period : null,
                "amount" => $amount,
                'for' => $for,
                'real_amount' => $sumUserRealPayments - $realAmountSell,
                'btc_price_now' => $btcPrice,
                'btc_price_last_payment' => $amount > 0 ? $btcPriceLastUserPayment : null,
                'exchange_rate_deduction' => $exchangeRateDeduction,
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
        $destination = $request->get("destination") ?? '';
        $isDestinationValid = $service->checkBlockchainAddress($destination, 'polygon');
        $acceptEarlyTerminationFee = $request->get("accept_early_termination_fee");
        $checkBalance = $this->service->checkBalance($accountUuid);
        if ($isDestinationValid && $isDestinationValid['response']['isValid'] && $acceptEarlyTerminationFee && $checkBalance) {
            $btcPrice = $this->tokenService->getBitcoinAmount();
            [
                $referralAmount,
                $bonusAmount,
                $dividendsAmount,
                $sumUserRealPayments,
                $sumUserPayments,
                $sumUserDividends,
                $lastUserPayment,
                $sumUserSells,
                $realAmountSell,
                $referralAmountSell,
                $bonusAmountSell,
                $dividendsAmountSell,
            ] = $this->service->getDataForConfirmSell($accountUuid);
            $btcPriceLastUserPayment = $lastUserPayment?->getBtcPrice();
            [
                $amount,
                $for,
                $earlyTerminationFee,
                $transactionFee,
                $allPaid,
                $apolloService,
                $exchangeRateDeduction
            ] = $this->calculateValues(
                $sumUserRealPayments,
                $sumUserPayments,
                $sumUserDividends,
                $lastUserPayment,
                $sumUserSells,
                $realAmountSell,
                $service,
                $btcPrice,
                $btcPriceLastUserPayment
            );
            $period = $this->getPeriod($lastUserPayment);
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
                    'referral_amount' => $referralAmount - $referralAmountSell,
                    'bonus_amount' => $bonusAmount - $bonusAmountSell,
                    'dividend_amount' => $dividendsAmount - $dividendsAmountSell,
                    'real_amount' => $sumUserRealPayments - $realAmountSell,
                    'total_amount_btc' => 1 / $btcPrice * $amount,
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
                'real_amount' => $sumUserRealPayments - $realAmountSell,
                'termination_fee' => $earlyTerminationFee,
                'transaction_fee' => $transactionFee,
                'return_all_paid' => $allPaid,
                'exchange_rate_deduction' => $exchangeRateDeduction,
                'total_amount' => $amount,
            ]));
            return response()->json([
                'data' => [
                    'success' => true,
                    'uuid' => $accountUuid,
                    "amount" => $for,
                    'destination' => $destination,
                    'accept_early_termination_fee' => $acceptEarlyTerminationFee,
                    'is_destination_valid' => $isDestinationValid,
                    'check_balance' => true,
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
                    'check_balance' => $checkBalance,
                ],
            ]);
        }
    }
}
