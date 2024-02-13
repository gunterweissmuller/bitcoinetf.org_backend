<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\Pipes\Callback;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\CallbackPipelineDto;
use App\Enums\Billing\Replenishment\StatusEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\ReplenishmentService;
use App\Services\Api\V1\Billing\WalletService;
use App\Services\Utils\CentrifugalService;
use Closure;

final readonly class FailurePipe implements PipeInterface
{
    public function __construct(
        private ReplenishmentService $replenishmentService,
        private WalletService $walletService,
        private CentrifugalService $centrifugalService,
    ) {
    }

    public function handle(CallbackPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($dto->getStatus() === 'failed' || $dto->getStatus() === 'expired') {
            $replenishment = $dto->getReplenishment();
            $replenishment->setStatus(($dto->getStatus() === 'failed') ? StatusEnum::FAILED->value : StatusEnum::EXPIRED->value);

            $this->replenishmentService->update([
                'uuid' => $replenishment->getUuid(),
            ], [
                'status' => $replenishment->getStatus(),
                'total_amount_btc' => $replenishment->getTotalAmountBtc(),
                'btc_price' => $replenishment->getBtcPrice(),
            ]);

            if ($dto->isReplenished()) {
                if ($replenishment->getDividendWalletUuid()) {
                    $this->refund($replenishment->getDividendWalletUuid(), $replenishment->getDividendAmount());
                }

                if ($replenishment->getReferralWalletUuid()) {
                    $this->refund($replenishment->getReferralWalletUuid(), $replenishment->getReferralAmount());
                }

                if ($replenishment->getBonusWalletUuid()) {
                    $this->refund($replenishment->getBonusWalletUuid(), $replenishment->getBonusAmount());
                }
            }

            $this->centrifugalService->publish('replenishment.'.$replenishment->getAccountUuid(), [
                'type' => 'updated',
                'data' => $replenishment->toArray(),
            ]);
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
