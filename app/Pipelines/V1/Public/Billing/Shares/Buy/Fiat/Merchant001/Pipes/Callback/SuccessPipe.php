<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\Pipes\Callback;

use App\Dto\DtoInterface;
use App\Dto\Models\Billing\PaymentDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\CallbackPipelineDto;
use App\Enums\Billing\Payment\TypeEnum as PaymentTypeEnum;
use App\Enums\Billing\Replenishment\StatusEnum;
use App\Enums\Billing\Wallet\TypeEnum;
use App\Enums\Billing\Wallet\TypeEnum as WalletTypeEnum;
use App\Enums\Kafka\ProducerEnum;
use App\Jobs\V1\Billing\Buy\UpdateDailyAumJob;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\PaymentService;
use App\Services\Api\V1\Billing\ReplenishmentService;
use App\Services\Api\V1\Billing\WalletService;
use App\Services\Api\V1\Referrals\CodeService;
use App\Services\Api\V1\Referrals\InviteService;
use App\Services\Api\V1\Settings\GlobalService;
use App\Services\Api\V1\Users\AccountService;
use App\Services\Utils\CentrifugalService;
use App\Services\Utils\KafkaProducerService;
use Closure;

final readonly class SuccessPipe implements PipeInterface
{
    public function __construct(
        private ReplenishmentService $replenishmentService,
        private PaymentService       $paymentService,
        private GlobalService        $globalService,
        private AccountService       $accountService,
        private InviteService        $inviteService,
        private CodeService          $codeService,
        private WalletService        $walletService,
        private CentrifugalService   $centrifugalService,
    )
    {
    }

    public function handle(CallbackPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($dto->getStatus() === 'success') {
            $accountUuid = $dto->getReplenishment()->getAccountUuid();

            $replenishment = $dto->getReplenishment();
            $replenishment->setStatus(StatusEnum::SUCCESS->value);

            if ($replenishment->getRealAmount() > 1000) {
                $replenishment->setRealAmount(1000);
            } elseif ($this->globalService->getMinReplenishmentAmount() < $replenishment->getRealAmount()) {
                $replenishment->setRealAmount($this->globalService->getMinReplenishmentAmount());
            }

            if ($dto->isReplenished()) {
                $replenishment->setTotalAmount(
                    $replenishment->getRealAmount() +
                    $replenishment->getAddedAmount()
                );
            } else {
                $replenishment->setTotalAmount(
                    $replenishment->getReferralAmount() +
                    $replenishment->getBonusAmount() +
                    $replenishment->getRealAmount() +
                    $replenishment->getAddedAmount()
                );
            }
            $replenishment->setTotalAmountBtc((1 / $replenishment->getBtcPrice() * $replenishment->getTotalAmount()) + $replenishment->getDividendBtcAmount());

            if ($dto->isReplenished()) {
                $this->replenishmentService->update([
                    'uuid' => $replenishment->getUuid(),
                ], [
                    'status' => $replenishment->getStatus(),
                    'real_amount' => $replenishment->getRealAmount(),
                    'added_amount' => $replenishment->getAddedAmount(),
                    'total_amount' => $replenishment->getTotalAmount(),
                    'total_amount_btc' => $replenishment->getTotalAmountBtc(),
                ]);
            }

            $payment = $this->paymentService->create(PaymentDto::fromArray([
                'account_uuid' => $accountUuid,
                'referral_wallet_uuid' => $replenishment->getReferralWalletUuid(),
                'bonus_wallet_uuid' => $replenishment->getBonusWalletUuid(),
                'dividend_wallet_uuid' => $replenishment->getDividendWalletUuid(),
                'referral_amount' => $replenishment->getReferralAmount(),
                'bonus_amount' => $replenishment->getBonusAmount(),
                'dividend_amount' => $replenishment->getDividendAmount() + $replenishment->getDividendRespAmount(),
                'real_amount' => ceil($replenishment->getRealAmount() + $replenishment->getAddedAmount()),
                'total_amount_btc' => $replenishment->getTotalAmountBtc(),
                'btc_price' => $replenishment->getBtcPrice(),
                'type' => PaymentTypeEnum::CREDIT_FROM_CLIENT->value,
            ]));

            if ($replenishment->getDividendRespAmount()) {
                $bonusWallet = $this->walletService->get([
                    'account_uuid' => $accountUuid,
                    'type' => TypeEnum::BONUS->value,
                ]);

                $this->paymentService->create(PaymentDto::fromArray([
                    'account_uuid' => $accountUuid,
                    'bonus_wallet_uuid' => $bonusWallet->getUuid(),
                    'bonus_amount' => $replenishment->getDividendRespAmount(),
                    'total_amount_btc' => (1 / $replenishment->getTotalAmountBtc()) * $replenishment->getDividendRespAmount(),
                    'btc_price' => $replenishment->getBtcPrice(),
                    'type' => PaymentTypeEnum::DEBIT_TO_CLIENT->value,
                ]));

                $this->refund(
                    $bonusWallet->getUuid(),
                    $replenishment->getDividendRespAmount(),
                );
            }

            if ($this->accountService->get([
                'uuid' => $accountUuid,
                'fast_reg' => true,
            ])) {
                $this->accountService->update([
                    'uuid' => $accountUuid,
                ], [
                    'fast_payment' => true,
                ]);
            }

            dispatch(new UpdateDailyAumJob());

            $this->centrifugalService->publish('replenishment.' . $replenishment->getAccountUuid(), [
                'type' => 'updated',
                'data' => [
                    ...$replenishment->toArray(),
                    'amount' => $payment->getTotalAmount(),
                ],
            ]);

            if ($invite = $this->inviteService->get(['account_uuid' => $accountUuid])) {
                if ($code = $this->codeService->get(['uuid' => $invite->getCodeUuid()])) {
                    if ($wallet = $this->walletService->get([
                        'account_uuid' => $code->getAccountUuid(),
                        'type' => WalletTypeEnum::REFERRAL->value,
                    ])) {
                        $bonusPercent = $this->accountService->getPersonalBonusValue($code->getAccountUuid());
                        if ($bonusPercent == 0) {
                            $bonusPercent = $this->globalService->getDefaultBonusValue();
                        }

                        $refAmount = ($bonusPercent / 100) * $replenishment->getRealAmount();

                        $this->walletService->update([
                            'uuid' => $wallet->getUuid(),
                        ], [
                            'amount' => $wallet->getAmount() + $refAmount,
                        ]);

                        $this->paymentService->create(PaymentDto::fromArray([
                            'account_uuid' => $code->getAccountUuid(),
                            'referral_wallet_uuid' => $wallet->getUuid(),
                            'referral_amount' => $refAmount,
                            'real_amount' => $refAmount,
                            'total_amount_btc' => 1 / $replenishment->getBtcPrice() * $refAmount,
                            'btc_price' => $replenishment->getBtcPrice(),
                            'type' => PaymentTypeEnum::DEBIT_TO_CLIENT->value,
                        ]));
                    }
                }
            }

            KafkaProducerService::handle(
                ProducerEnum::BILLING_SHARES_BUY,
                'user purchase success',
                [
                    'entity' => 'replenishment of the fund',
                    'record' => [
                        'account_uuid' => $accountUuid,
                        'payment_uuid' => $payment->getUuid(),
                        'amount' => $payment->getTotalAmount(),
                        'reinvest' => (bool) $replenishment->getDividendWalletUuid()
                    ],
                ],
            );
        }

        return $next($dto);
    }

    private function refund(string $walletUuid, float $amount): void
    {
        if ($wallet = $this->walletService->get(['uuid' => $walletUuid])) {
            $this->walletService->update([
                'uuid' => $wallet->getUuid(),
            ], [
                'amount' => $wallet->getAmount() + $amount,
            ]);
        }
    }
}
