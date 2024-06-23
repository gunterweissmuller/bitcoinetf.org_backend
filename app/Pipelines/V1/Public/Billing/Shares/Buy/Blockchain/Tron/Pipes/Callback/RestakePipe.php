<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Shares\Buy\Blockchain\Tron\Pipes\Callback;

use App\Dto\DtoInterface;
use App\Dto\Models\Billing\PaymentDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Blockchain\Tron\CallbackPipelineDto;
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
use Illuminate\Support\Carbon;
use App\Models\Billing\Replenishment;

final readonly class RestakePipe implements PipeInterface
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
        $accountUuid = $dto->getAccount()->getUuid();

        $replenishment = $dto->getReplenishment();
        $replenishment->setStatus(StatusEnum::SUCCESS->value);

        $realAmount = number_format($replenishment->getRealAmount(), 8, '.', '');
        $trcBonus = number_format($this->globalService->getTrcBonus(), 8, '.', '');
        $respAmount = null;
        if ($replenishment->getCheckDiscount() && $trcBonus > 0) {
            $percent100 = number_format(100, 8, '.', '');
            $percent = bcsub(
                $percent100,
                bcmul($percent100, $trcBonus, 8),
                8
            );

            $totalAmount = bcmul(
                bcdiv($realAmount, $percent, 8),
                $percent100,
                8
            );
            $respAmount = bcsub($totalAmount, $realAmount, 8);
        }

        $replenishment->setAddedAmount((float)$respAmount);

        $bonusWallet = null;
        if ($replenishment->getAddedAmount()) {
            $bonusWallet = $this->walletService->get([
                'account_uuid' => $accountUuid,
                'type' => WalletTypeEnum::BONUS->value
            ]);
            $this->paymentService->create(PaymentDto::fromArray([
                'account_uuid' => $accountUuid,
                'bonus_wallet_uuid' => $bonusWallet->getUuid(),
                'bonus_amount' => $replenishment->getAddedAmount(),
                'type' => PaymentTypeEnum::DEBIT_TO_CLIENT->value,
                'real_amount' => 0,
                'total_amount_btc' => 1 / $replenishment->getBtcPrice() * $replenishment->getAddedAmount(),
                'btc_price' => $replenishment->getBtcPrice(),
                'created_at' => Carbon::now()->subSecond()->toDateTimeString(),
                'updated_at' => Carbon::now()->subSecond()->toDateTimeString(),
            ]));

            $bonusAmountFloor = floor($replenishment->getAddedAmount());
            $bonusAmountResp = $replenishment->getAddedAmount() - $bonusAmountFloor;

            if ($bonusAmountResp > 0) {
                $this->refund(
                    $bonusWallet->getUuid(),
                    $bonusAmountResp,
                );
            }

            $replenishment->setAddedAmount($bonusAmountFloor);
        }

        $replenishment->setTotalAmount(
            $replenishment->getReferralAmount() +
            $replenishment->getBonusAmount() +
            $replenishment->getRealAmount() +
            $replenishment->getAddedAmount() +
            $replenishment->getDividendAmount()
        );
        $replenishment->setTotalAmountBtc(1 / $replenishment->getBtcPrice() * $replenishment->getTotalAmount());

        if ($dto->isReplenishment()) {
            $this->replenishmentService->update([
                'uuid' => $replenishment->getUuid(),
            ], [
                'status' => $replenishment->getStatus(),
                'added_amount' => $replenishment->getAddedAmount(),
                'total_amount' => $replenishment->getTotalAmount(),
                'total_amount_btc' => $replenishment->getTotalAmountBtc(),
            ]);
        } else {
            $lastOrderType = Replenishment::query()
                ->where(
                    ['account_uuid' => $accountUuid],
                    ['order_type', '!=', null]
                )
                ->orderBy('created_at', 'desc')
                ->first()
                ->value('order_type');
            $replenishment->setOrderType($lastOrderType);
            $replenishmentRecord = $this->replenishmentService->create($replenishment);
            $this->replenishmentService->update([
                'uuid' => $replenishmentRecord->getUuid(),
            ], [
                'added_amount' => ceil($replenishment->getBonusAmount() + $replenishment->getAddedAmount()),
            ]);
        }

        $payment = $this->paymentService->create(PaymentDto::fromArray([
            'account_uuid' => $accountUuid,
            'referral_wallet_uuid' => $replenishment->getReferralWalletUuid(),
            'bonus_wallet_uuid' => $bonusWallet?->getUuid() ?? null,
            'dividend_wallet_uuid' => $replenishment->getDividendWalletUuid(),
            'referral_amount' => $replenishment->getReferralAmount(),
            'bonus_amount' => ceil($replenishment->getBonusAmount() + $replenishment->getAddedAmount()),
            'dividend_amount' => $replenishment->getDividendAmount() + $replenishment->getDividendRespAmount(),
            'real_amount' => $replenishment->getRealAmount(),
            'total_amount_btc' => $replenishment->getTotalAmountBtc(),
            'btc_price' => $replenishment->getBtcPrice(),
            'type' => PaymentTypeEnum::CREDIT_FROM_CLIENT->value,
        ]));

        $bonusWallet = $this->walletService->get([
            'account_uuid' => $accountUuid,
            'type' => TypeEnum::BONUS->value,
        ]);

        if ($replenishment->getDividendRespAmount()) {
            $this->paymentService->create(PaymentDto::fromArray([
                'account_uuid' => $accountUuid,
                'bonus_wallet_uuid' => $bonusWallet->getUuid(),
                'bonus_amount' => $replenishment->getDividendRespAmount(),
                'total_amount_btc' => 1 / $replenishment->getBtcPrice() * $replenishment->getDividendRespAmount(),
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

        $this->centrifugalService->publish('replenishment.' . $accountUuid, [
            'type' => 'updated',
            'data' => [
                ...$replenishment->toArray(),
                'amount' => $replenishment->getTotalAmount(),
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
                    'amount' => $replenishment->getTotalAmount(),
                    'reinvest' => (bool)$replenishment->getDividendWalletUuid()
                ],
            ],
        );

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
