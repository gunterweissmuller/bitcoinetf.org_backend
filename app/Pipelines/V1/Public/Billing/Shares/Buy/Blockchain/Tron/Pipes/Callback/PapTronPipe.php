<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Shares\Buy\Blockchain\Tron\Pipes\Callback;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Blockchain\Tron\CallbackPipelineDto;
use App\Pipelines\PipeInterface;
use Closure;
use App\Enums\Pap\Asset\AssetEnum;
use App\Enums\Billing\Replenishment\StatusEnum as ReplenishmentStatusEnum;
use App\Services\Api\V1\Pap\TrackingService;


final readonly class PapTronPipe implements PipeInterface
{
    public function __construct(
        private readonly TrackingService $trackingService,
    )
    {    
    }

    public function handle(CallbackPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $accountUuid = $dto->getAccount()->getUuid();
        $record = $this->trackingService->get(['account_uuid' => $account_uuid]);
        if ($record !== null && $dto->getReplenishment()->getStatus() === ReplenishmentStatusEnum::SUCCESS->value)
        {
            $real_amount = $dto->getReplenishment()->getRealAmount();
            $this->trackingService->createSale($accountUuid, $real_amount, AssetEnum::Tron->value);
        }
        return $next($dto);
    }
}
