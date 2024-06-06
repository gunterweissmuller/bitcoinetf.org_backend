<?php

declare(strict_types=1);

namespace app\Pipelines\V1\Public\Billing\Withdrawal\Pipes\Payout;

use App\Dto\DtoInterface;
use App\Pipelines\PipeInterface;
use App\Services\Utils\CentrifugalService;
use Closure;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\PayoutPipelineDto;

final readonly class NewCentrifugalPipe implements PipeInterface
{
    public function __construct(
        private readonly CentrifugalService $centrifugalService
    ) {
    }

    public function handle(PayoutPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $this->centrifugalService->publish('payout.'.$dto->getSell()->getAccountUuid(), [
            'type' => 'payout_pending',
            'data' => $dto->getSell()->toArray(),
        ]);

        return $next($dto);
    }
}
