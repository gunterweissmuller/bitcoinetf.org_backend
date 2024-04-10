<?php

declare(strict_types=1);

namespace App\Pipelines\V3\Public\Billing\Shares\Buy\Payment\Pipes\CancelOrder;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V3\Public\Billing\Shares\Buy\Payment\CancelOrderPipelineDto;
use App\Exceptions\Pipelines\V1\Billing\ReplenishmentNotFoundException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\ReplenishmentService;
use Closure;

final readonly class ReplenishmentPipe implements PipeInterface
{
    public function __construct(
        private ReplenishmentService $replenishmentService,
    )
    {
    }

    /**
     * @param CancelOrderPipelineDto|DtoInterface $dto
     * @param Closure $next
     * @return DtoInterface
     */
    public function handle(CancelOrderPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $replenishment = $dto->getReplenishment();

        if ($this->replenishmentService->get(['uuid' => $replenishment->getUuid()])) {
            $this->replenishmentService->cancelReplenishment($replenishment->getUuid());
            $replenishment = $this->replenishmentService->get(['uuid' => $replenishment->getUuid()]);
            $dto->setReplenishment($replenishment);
        } else {
            throw new ReplenishmentNotFoundException();
        }

        return $next($dto);
    }
}
