<?php

declare(strict_types=1);

namespace app\Pipelines\V1\Public\Billing\Withdrawal\Pipes\Payout;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\DividendPipelineDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\ReferralPipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Utils\CentrifugalService;
use Closure;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\PayoutPipelineDto;

final readonly class UpdateCentrifugalPipe implements PipeInterface
{
    public function __construct(
        private readonly CentrifugalService $centrifugalService
    ) {
    }

    public function handle(PayoutPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $this->centrifugalService->publish('payout.'.$dto->getSell()->getAccountUuid(), [
            'type' => 'payout_success',
            'data' => $dto->getSell()->toArray(),
        ]);

        return $next($dto);
    }
}
