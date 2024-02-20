<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Login;

use App\Dto\Pipelines\Api\V1\Auth\Login\LoginGooglePipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginPipelineDto;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\V1\Auth\Login\Pipes\Login\AccountPipe as LoginAccountPipe;
use App\Pipelines\V1\Auth\Login\Pipes\LoginGoogle\AccountPipe as LoginGoogleAccountPipe;
use App\Pipelines\V1\Auth\Login\Pipes\Login\EmailPipe as LoginEmailPipe;
use App\Pipelines\V1\Auth\Login\Pipes\Login\JwtPipe as LoginJwtPipe;

final class LoginPipeline extends AbstractPipeline
{
    public function login(LoginPipelineDto $dto): array
    {
        return $this->pipeline([
            LoginEmailPipe::class,
            LoginAccountPipe::class,
            LoginJwtPipe::class,
        ], $dto);
    }

    public function loginGoogle(LoginGooglePipelineDto $dto): array
    {
        return $this->pipeline([
            LoginEmailPipe::class,
            LoginGoogleAccountPipe::class,
            LoginJwtPipe::class,
        ], $dto);
    }
}
