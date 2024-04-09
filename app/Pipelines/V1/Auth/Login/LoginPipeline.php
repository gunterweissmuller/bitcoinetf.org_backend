<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Login;

use App\Dto\Pipelines\Api\V1\Auth\Login\LoginApplePipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginFacebookPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginGooglePipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginMetamaskPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginTelegramPipelineDto;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\V1\Auth\Login\Pipes\Login\AccountPipe as LoginAccountPipe;
use App\Pipelines\V1\Auth\Login\Pipes\LoginFacebook\AccountPipe as LoginFacebookAccountPipe;
use App\Pipelines\V1\Auth\Login\Pipes\LoginFacebook\FacebookPipe as LoginFacebookPipe;
use App\Pipelines\V1\Auth\Login\Pipes\LoginApple\ApplePipe as LoginApplePipe;
use App\Pipelines\V1\Auth\Login\Pipes\LoginGoogle\AccountPipe as LoginGoogleAccountPipe;
use App\Pipelines\V1\Auth\Login\Pipes\Login\EmailPipe as LoginEmailPipe;
use App\Pipelines\V1\Auth\Login\Pipes\Login\JwtPipe as LoginJwtPipe;
use App\Pipelines\V1\Auth\Login\Pipes\LoginMetamask\AccountPipe as LoginMetamaskAccountPipe;
use App\Pipelines\V1\Auth\Login\Pipes\LoginApple\AccountPipe as LoginAppleAccountPipe;
use App\Pipelines\V1\Auth\Login\Pipes\LoginMetamask\WalletPipe as LoginWalletPipe;
use App\Pipelines\V1\Auth\Login\Pipes\LoginTelegram\AccountPipe as LoginTelegramAccountPipe;
use App\Pipelines\V1\Auth\Login\Pipes\LoginTelegram\TelegramPipe as LoginTelegramPipe;

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

    public function loginMetamask(LoginMetamaskPipelineDto $dto): array
    {
        return $this->pipeline([
            LoginWalletPipe::class,
            LoginMetamaskAccountPipe::class,
            LoginJwtPipe::class,
        ], $dto);
    }

    public function loginApple(LoginApplePipelineDto $dto): array
    {
        return $this->pipeline([
            LoginApplePipe::class,
            LoginAppleAccountPipe::class,
            LoginJwtPipe::class,
        ], $dto);
    }

    public function loginTelegram(LoginTelegramPipelineDto $dto): array
    {
        return $this->pipeline([
            LoginTelegramPipe::class,
            LoginTelegramAccountPipe::class,
            LoginJwtPipe::class,
        ], $dto);
    }

    public function loginFacebook(LoginFacebookPipelineDto $dto): array
    {
        return $this->pipeline([
            LoginFacebookPipe::class,
            LoginFacebookAccountPipe::class,
            LoginJwtPipe::class,
        ], $dto);
    }
}
