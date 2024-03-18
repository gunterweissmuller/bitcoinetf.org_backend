<?php

declare(strict_types=1);

namespace App\Pipelines\V3\Public\Billing\Shares\Buy\Apollopayment\Pipes\Webhook;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Blockchain\Tron\CallbackPipelineDto;
use App\Pipelines\PipeInterface;
use Closure;
use App\Enums\Pap\Asset\AssetEnum;
use App\Enums\Pap\Event\EventEnum;
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
        $record = $this->trackingService->get(['account_uuid' => $accountUuid, 'event_type' => EventEnum::Signup->value]);
        if ($record !== null && $dto->getReplenishment()->getStatus() === ReplenishmentStatusEnum::SUCCESS->value)
        {
            $pap_id = $record->getPapId();
            $real_amount = $dto->getReplenishment()->getRealAmount();
            $this->trackingService->createSale($accountUuid, $pap_id, $real_amount, AssetEnum::Tron->value);
        }
        return $next($dto);
    }
}
