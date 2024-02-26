<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\ReferralsCallback;

use App\Dto\DtoInterface;
use App\Dto\Models\Billing\PaymentDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\ReferralCallbackPipelineDto;
use App\Enums\Billing\Payment\TypeEnum;
use App\Enums\Billing\Withdrawal\StatusEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\PaymentService;
use App\Services\Api\V1\Billing\TokenService;
use App\Services\Api\V1\Billing\WalletService;
use App\Services\Api\V1\Billing\WithdrawalService;
use Closure;

final readonly class FailurePipe implements PipeInterface
{
    public function __construct(
        private WithdrawalService $withdrawalService,
        private WalletService $walletService,
        private PaymentService $paymentService,
        private TokenService $tokenService,
    ) {
    }

    public function handle(ReferralCallbackPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($dto->getStatus() === 'failed' || $dto->getStatus() === 'expired') {
            $btcPrice = $this->tokenService->getBitcoinAmount();

            $withdrawal = $dto->getWithdrawal();
            $withdrawal->setStatus(($dto->getStatus() === 'failed') ? StatusEnum::FAILED->value : StatusEnum::EXPIRED->value);

            $this->withdrawalService->update([
                'uuid' => $withdrawal->getUuid(),
            ], [
                'status' => $withdrawal->getStatus(),
                'total_amount_btc' => $withdrawal->getTotalAmountBtc(),
                'btc_price' => $withdrawal->getBtcPrice(),
            ]);

            if ($withdrawal->getDividendWalletUuid()) {
                $this->refund($withdrawal->getDividendWalletUuid(), $withdrawal->getDividendAmount());
            }

            if ($withdrawal->getReferralWalletUuid()) {
                $this->refund($withdrawal->getReferralWalletUuid(), $withdrawal->getReferralAmount());
            }

            $this->paymentService->create(PaymentDto::fromArray([
                'account_uuid' => $withdrawal->getAccountUuid(),
                'referral_wallet_uuid' => $withdrawal->getReferralWalletUuid(),
                'dividend_wallet_uuid' => $withdrawal->getDividendWalletUuid(),
                'referral_amount' => $withdrawal->getReferralAmount(),
                'dividend_amount' => $withdrawal->getDividendAmount(),
                'total_amount_btc' => 1 / $btcPrice * $withdrawal->getTotalAmount(),
                'btc_price' => $btcPrice,
                'type' => TypeEnum::DEBIT_TO_CLIENT->value,
            ]));
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
