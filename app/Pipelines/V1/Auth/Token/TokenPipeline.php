<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Token;

use App\Dto\Pipelines\Api\V1\Auth\Token\RefreshPipelineDto;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\V1\Auth\Token\Pipes\Refresh\AccountPipe as RefreshAccountPipe;
use App\Pipelines\V1\Auth\Token\Pipes\Refresh\JwtPipe as RefreshJwtPipe;
use App\Pipelines\V1\Auth\Token\Pipes\Refresh\RefreshTokenPipe as RefreshRefreshTokenPipe;

final class TokenPipeline extends AbstractPipeline
{
    public function refresh(RefreshPipelineDto $dto): array
    {
        return $this->pipeline([
            RefreshRefreshTokenPipe::class,
            RefreshAccountPipe::class,
            RefreshJwtPipe::class,
        ], $dto);
    }
}
