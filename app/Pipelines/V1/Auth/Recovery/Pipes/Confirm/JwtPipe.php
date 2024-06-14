<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Recovery\Pipes\Confirm;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Token\RefreshPipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Auth\RefreshTokenService;
use Closure;

final class JwtPipe implements PipeInterface
{
    public function __construct(
        private readonly RefreshTokenService $refreshTokenService,
    )
    {
    }

    public function handle(RefreshPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $this->refreshTokenService->delete([
            'account_uuid' => $dto->getAccount()->getUuid(),
        ]);

        return $next($dto);
    }
}
