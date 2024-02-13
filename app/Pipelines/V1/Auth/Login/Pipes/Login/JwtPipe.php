<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Login\Pipes\Login;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginPipelineDto;
use App\Enums\Core\JWT\TypeEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Auth\RefreshTokenService;
use App\Services\Utils\CentrifugalService;
use App\Services\Utils\JWTService;
use Closure;
use Illuminate\Support\Carbon;

final class JwtPipe implements PipeInterface
{
    public function __construct(
        private readonly RefreshTokenService $refreshTokenService,
        private readonly CentrifugalService $centrifugalService
    ) {
    }

    public function handle(LoginPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        /** @var JWTService $jwtService */
        $jwtService = app(JWTService::class);

        $jwtAccess = $jwtService->generateToken(TypeEnum::Access, [
            'data' => $jwtService::getAccessPayload($dto->getAccount()),
        ]);

        $jwtRefresh = $jwtService->generateToken(TypeEnum::Refresh, [
            'data' => $jwtService::getRefreshPayload($dto->getAccount()->getUuid()),
        ]);

        $this->refreshTokenService->create($dto->getAccount()->getUuid(), $jwtRefresh);

        $dto->setWebsocketToken($this->centrifugalService->getToken(
            $dto->getAccount()->getUuid(),
            Carbon::now()->addMinutes(config('jwt.ttl.access'))->unix()
        ));

        $dto->setJwtAccess($jwtAccess);
        $dto->setJwtRefresh($jwtRefresh);

        return $next($dto);
    }
}
