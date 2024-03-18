<?php

declare(strict_types=1);

namespace App\Pipelines\V3\Public\Billing\Shares\Buy\Pipes\Init;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitPipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V3\Apollopayment\ApollopaymentService;
use Closure;
use Exception;

final readonly class ApolloClientPipe implements PipeInterface
{
    public function __construct(
        private ApollopaymentService $apollopaymentService,
    )
    {
    }

    public function handle(InitPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        try {
            $this->apollopaymentService->createUser(
                $dto->getAccount()->getUuid(),
                $dto->getEmail()->getEmail(),
                $dto->getProfile()->getFullName(),
                $dto->getApolloClient()
            );
        } catch (Exception $e) {
        }

        return $next($dto);
    }
}
