<?php

declare(strict_types=1);

namespace app\Pipelines\V1\Public\Billing\Withdrawal\Pipes\Payout;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\DividendPipelineDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\ReferralPipelineDto;
use App\Enums\Billing\Withdrawal\StatusEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V3\Billing\SellService;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\PayoutPipelineDto;
use Closure;

final readonly class PayoutWebhookPipe implements PipeInterface
{
    public function __construct(
        private SellService $sellService,
    ) {
    }

    public function handle(PayoutPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $sell = $this->sellService->get(['uuid' => $dto->getSell()->getUuid(),]);
        $accountUuid = $sell->getAccountUuid();
        $dto->getSell()->setAccountUuid($accountUuid);
        $this->sellService->update([
            'uuid' => $sell->getUuid(),
        ], [
            'status' => StatusEnum::SUCCESS->value
        ]);

        return $next($dto);
    }
}
