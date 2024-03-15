<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Withdrawal\Pipes;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\DividendPipelineDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\ReferralPipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Utils\CentrifugalService;
use Closure;

final readonly class UpdateCentrifugalPipe implements PipeInterface
{
    public function __construct(
        private readonly CentrifugalService $centrifugalService
    ) {
    }

    public function handle(DividendPipelineDto|ReferralPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $this->centrifugalService->publish('wallet.'.$dto->getWithdrawal()->getAccountUuid(), [
            'type' => 'update_withdrawal',
            'data' => $dto->getWithdrawal()->toArray(),
        ]);

        return $next($dto);
    }
}
