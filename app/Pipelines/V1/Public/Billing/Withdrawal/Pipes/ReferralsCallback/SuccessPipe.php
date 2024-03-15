<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\ReferralsCallback;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\ReferralCallbackPipelineDto;
use App\Enums\Billing\Replenishment\StatusEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\WithdrawalService;
use Closure;

final readonly class SuccessPipe implements PipeInterface
{
    public function __construct(
        private WithdrawalService $withdrawalService,
    ) {
    }

    public function handle(ReferralCallbackPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($dto->getStatus() === 'success') {
            $withdrawal = $dto->getWithdrawal();
            $withdrawal->setStatus(StatusEnum::SUCCESS->value);

            $this->withdrawalService->update([
                'uuid' => $withdrawal->getUuid(),
            ], [
                'status' => $withdrawal->getStatus(),
            ]);
        }

        return $next($dto);
    }
}
