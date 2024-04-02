<?php

declare(strict_types=1);

namespace App\Pipelines\V3\Public\Billing\Shares\Buy\Payment\Pipes\CancelOrder;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V3\Public\Billing\Shares\Buy\Payment\CancelOrderPipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\WalletService;
use Closure;

final readonly class WalletPipe implements PipeInterface
{
    public function __construct(
        private WalletService $walletService,
    ) {
    }

    /**
     * @param CancelOrderPipelineDto|DtoInterface $dto
     * @param Closure $next
     * @return DtoInterface
     */
    public function handle(CancelOrderPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $replenishment = $dto->getReplenishment();

        if ($replenishment->getDividendWalletUuid()) {
            $this->walletService->refund(
                $replenishment->getDividendWalletUuid(),
                $replenishment->getDividendAmount()
            );
        }

        if ($replenishment->getReferralWalletUuid()) {
            $this->walletService->refund(
                $replenishment->getReferralWalletUuid(),
                $replenishment->getReferralAmount()
            );
        }

        if ($replenishment->getBonusWalletUuid()) {
            $this->walletService->refund(
                $replenishment->getBonusWalletUuid(),
                $replenishment->getBonusAmount()
            );
        }

        return $next($dto);
    }
}
