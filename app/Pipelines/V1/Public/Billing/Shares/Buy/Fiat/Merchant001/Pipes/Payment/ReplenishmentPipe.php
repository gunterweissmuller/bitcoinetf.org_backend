<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\Pipes\Payment;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\PaymentPipelineDto;
use App\Exceptions\Pipelines\V1\Billing\ReplenishmentNotFoundException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\ReplenishmentService;
use Closure;

final class ReplenishmentPipe implements PipeInterface
{
    public function __construct(
        private readonly ReplenishmentService $replenishmentService,
    ) {
    }

    public function handle(PaymentPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($replenishment = $this->replenishmentService->get(['uuid' => $dto->getReplenishment()->getUuid()])) {
            $dto->setReplenishment($replenishment);
        } else {
            throw new ReplenishmentNotFoundException();
        }

        return $next($dto);
    }
}
