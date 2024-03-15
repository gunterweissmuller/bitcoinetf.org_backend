<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Token\Pipes\Refresh;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Token\RefreshPipelineDto;
use App\Enums\Auth\RefreshToken\StatusEnum;
use App\Exceptions\Pipelines\V1\Auth\IncorrectRefreshTokenException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Auth\RefreshTokenService;
use App\Services\Utils\JWTService;
use Closure;

final class RefreshTokenPipe implements PipeInterface
{
    public function __construct(
        private readonly RefreshTokenService $refreshTokenService,
    ) {
    }

    public function handle(RefreshPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        /** @var JWTService $jwtService */
        $jwtService = app(JWTService::class);

        $payload = $jwtService->getPayload($dto->getJWTRefresh()->getToken());

        if ($refreshToken = $this->refreshTokenService->get([
            'account_uuid' => $payload['account_uuid'],
            'token' => $dto->getJWTRefresh()->getToken(),
            'status' => StatusEnum::Unused->value,
        ])) {
            $this->refreshTokenService->update([
                'uuid' => $refreshToken->getUuid(),
            ], [
                'status' => StatusEnum::Used->value,
            ]);

            $dto->setRefreshToken($refreshToken);
            $dto->setJWTRefresh(null);
        } else {
            throw new IncorrectRefreshTokenException();
        }

        return $next($dto);
    }
}
