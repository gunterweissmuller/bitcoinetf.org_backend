<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Shares\Buy\Pipes\Init;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\InitPipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\ReplenishmentService;
use Closure;

final readonly class ReplenishmentPipe implements PipeInterface
{
    public function __construct(
        private ReplenishmentService $replenishmentService,
    ) {
    }

    public function handle(InitPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $replenishment = $dto->getReplenishment();

        $btcPrice = $replenishment->getBtcPrice();

        $replenishment->setAccountUuid($dto->getAccount()->getUuid());
        $replenishment->setTotalAmount($replenishment->getReferralAmount() + $replenishment->getBonusAmount() + $replenishment->getRealAmount());
        $replenishment->setTotalAmountBtc((1 / $btcPrice * $replenishment->getTotalAmount()) + $replenishment->getDividendBtcAmount());

        $replenishment = $this->replenishmentService->create($replenishment);

        $dto->setReplenishment($replenishment);

        return $next($dto);
    }
}
