<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Withdrawal\Pipes;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\DividendPipelineDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\ReferralPipelineDto;
use App\Enums\Billing\Withdrawal\StatusEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\WithdrawalService;
use Closure;

final readonly class WithdrawalWebhookPipe implements PipeInterface
{
    public function __construct(
        private WithdrawalService $withdrawalService,
    ) {
    }

    public function handle(DividendPipelineDto|ReferralPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $withdrawal = $this->withdrawalService->get(['uuid' => $dto->getWithdrawal()->getUuid(),]);
        $accountUuid = $withdrawal->getAccountUuid();
        $dto->getWithdrawal()->setAccountUuid($accountUuid);
        $this->withdrawalService->update([
            'uuid' => $withdrawal->getUuid(),
        ], [
            'status' => StatusEnum::SUCCESS->value
        ]);

        return $next($dto);
    }
}
