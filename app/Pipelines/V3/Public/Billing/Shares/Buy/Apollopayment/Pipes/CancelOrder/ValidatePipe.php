<?php

declare(strict_types=1);

namespace App\Pipelines\V3\Public\Billing\Shares\Buy\Apollopayment\Pipes\CancelOrder;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V3\Public\Billing\Shares\Buy\Apollopayment\CancelOrderPipelineDto;
use App\Enums\Billing\Replenishment\StatusEnum;
use App\Exceptions\Pipelines\V1\Billing\ReplenishmentNotFoundException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\ReplenishmentService;
use Closure;

final readonly class ValidatePipe implements PipeInterface
{
    public function __construct(
        private ReplenishmentService $replenishmentService,
    )
    {
    }

    public function handle(CancelOrderPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $replenishment = $dto->getReplenishment();

        if (!$this->replenishmentService->get([
            'uuid' => $replenishment->getUuid(),
            'account_uuid' => $replenishment->getAccountUuid(),
            'status' => StatusEnum::INIT->value,
        ])) {
            throw new ReplenishmentNotFoundException();
        }

        return $next($dto);
    }
}
