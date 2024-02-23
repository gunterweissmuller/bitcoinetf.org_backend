<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register;

use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmMetamaskPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitApplePipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitMetamaskPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmGooglePipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitGooglePipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitPipelineDto;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\V1\Auth\Register\Pipes\Confirm\AccountPipe as ConfirmAccountPipe;
use App\Pipelines\V1\Auth\Register\Pipes\ConfirmMetamaskAuth\AccountPipe as ConfirmMetamaskAccountPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Confirm\BonusPipe as ConfirmBonusPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Confirm\CodePipe as ConfirmCodePipe;
use App\Pipelines\V1\Auth\Register\Pipes\Confirm\EmailPipe as ConfirmEmailPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Confirm\JwtPipe as ConfirmJwtPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Confirm\MailPipe as ConfirmMailPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\AccountPipe as InitAccountPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\BonusPipe as InitBonusPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\EmailPipe as InitEmailPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\EventsPipe as InitEventsPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\InvitePipe as InitInvitePipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\NewCodePipe as InitNewCodePipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\ProfilePipe as InitProfilePipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\TronWalletPipe as InitTronWalletPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\ValidatePipe as InitValidatePipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\WalletPipe as InitWalletPipe;
use App\Pipelines\V1\Auth\Register\Pipes\ConfirmGoogleAuth\AccountPipe as ConfirmGoogleAuthAccountPipe;
use App\Pipelines\V1\Auth\Register\Pipes\InitGoogleAuth\EventsPipe as InitGoogleAuthEventsPipe;
use App\Pipelines\V1\Auth\Register\Pipes\ConfirmGoogleAuth\ValidatePipe as ConfirmGoogleAuthValidatePipe;
use App\Pipelines\V1\Auth\Register\Pipes\ConfirmGoogleAuth\ProfilePipe as ConfirmGoogleAuthProfilePipe;
use App\Pipelines\V1\Auth\Register\Pipes\InitMetamaskAuth\WalletPipe as InitMetamaskWalletPipe;
use App\Pipelines\V1\Auth\Register\Pipes\InitMetamaskAuth\ValidatePipe as InitMetamaskValidatePipe;
use App\Pipelines\V1\Auth\Register\Pipes\InitMetamaskAuth\AccountPipe as InitMetamaskAccountPipe;
use App\Pipelines\V1\Auth\Register\Pipes\InitMetamaskAuth\BillingWalletPipe as InitMetamaskBillingWalletPipe;
use App\Pipelines\V1\Auth\Register\Pipes\InitMetamaskAuth\BonusPipe as InitMetamaskBonusPipe;
use App\Pipelines\V1\Auth\Register\Pipes\InitMetamaskAuth\EmailPipe as InitMetamaskEmailPipe;
use App\Pipelines\V1\Auth\Register\Pipes\InitMetamaskAuth\InvitePipe as InitMetamaskInvitePipe;
use App\Pipelines\V1\Auth\Register\Pipes\InitMetamaskAuth\NewCodePipe as InitMetamaskNewCodePipe;
use App\Pipelines\V1\Auth\Register\Pipes\InitMetamaskAuth\ProfilePipe as InitMetamaskProfilePipe;

use App\Pipelines\V1\Auth\Register\Pipes\InitAppleAuth\AppleAccountPipe as InitAppleAuthAppleAccountPipe;
use App\Pipelines\V1\Auth\Register\Pipes\InitAppleAuth\ValidatePipe as InitAppleAuthValidatePipe;

final class RegisterPipeline extends AbstractPipeline
{
    public function init(InitPipelineDto $dto): array
    {
        return $this->pipeline([
            InitValidatePipe::class,
            InitAccountPipe::class,
            InitProfilePipe::class,
            InitEmailPipe::class,
            InitWalletPipe::class,
            InitInvitePipe::class,
            InitTronWalletPipe::class,
            InitNewCodePipe::class,
            InitBonusPipe::class,
            InitEventsPipe::class,
        ], $dto);
    }

    public function confirm(ConfirmPipelineDto $dto): array
    {
        return $this->pipeline([
            ConfirmEmailPipe::class,
            ConfirmCodePipe::class,
            ConfirmAccountPipe::class,
            ConfirmBonusPipe::class,
            ConfirmJwtPipe::class,
            ConfirmMailPipe::class,
        ], $dto);
    }

    public function initGoogleAuth(InitGooglePipelineDto $dto): array
    {
        return $this->pipeline([
            InitValidatePipe::class,
            InitAccountPipe::class,
            InitProfilePipe::class,
            InitEmailPipe::class,
            InitWalletPipe::class,
            InitInvitePipe::class,
            InitTronWalletPipe::class,
            InitNewCodePipe::class,
            InitBonusPipe::class,
            InitGoogleAuthEventsPipe::class,
        ], $dto);
    }

    public function confirmGoogleAuth(ConfirmGooglePipelineDto $dto): array
    {
        return $this->pipeline([
            ConfirmGoogleAuthValidatePipe::class,
            ConfirmEmailPipe::class,
            ConfirmGoogleAuthAccountPipe::class,
            ConfirmGoogleAuthProfilePipe::class,
            ConfirmBonusPipe::class,
            ConfirmJwtPipe::class,
            ConfirmMailPipe::class,
        ], $dto);
    }

    public function initMetamaskAuth(InitMetamaskPipelineDto $dto): array
    {
        return $this->pipeline([
            InitMetamaskValidatePipe::class,
            InitMetamaskAccountPipe::class,
            InitMetamaskEmailPipe::class,
            InitMetamaskProfilePipe::class,
            InitMetamaskWalletPipe::class,
            InitMetamaskBillingWalletPipe::class,
            InitMetamaskInvitePipe::class,
            InitTronWalletPipe::class,
            InitMetamaskNewCodePipe::class,
            InitMetamaskBonusPipe::class,
            InitEventsPipe::class,
        ], $dto);
    }

    public function confirmMetamaskAuth(ConfirmMetamaskPipelineDto $dto): array
    {
        return $this->pipeline([
            ConfirmEmailPipe::class,
            ConfirmCodePipe::class,
            ConfirmMetamaskAccountPipe::class,
            ConfirmBonusPipe::class,
            ConfirmJwtPipe::class,
            ConfirmMailPipe::class,
        ], $dto);
    }

    public function initAppleAuth(InitApplePipelineDto $dto): array
    {
        return $this->pipeline([
            InitAppleAuthValidatePipe::class,
            InitAccountPipe::class,
            InitAppleAuthAppleAccountPipe::class,
        ], $dto);
        return $this->pipeline([
            InitValidatePipe::class,
            InitAccountPipe::class,
            InitAppleAuthAppleAccountPipe::class,
            InitProfilePipe::class,
            InitEmailPipe::class,
            InitWalletPipe::class,
            InitInvitePipe::class,
            InitTronWalletPipe::class,
            InitNewCodePipe::class,
            InitBonusPipe::class,
            InitGoogleAuthEventsPipe::class,
        ], $dto);
    }

    public function confirmAppleAuth(ConfirmGooglePipelineDto $dto): array
    {
        return $this->pipeline([
            ConfirmGoogleAuthValidatePipe::class,
            ConfirmEmailPipe::class,
            ConfirmGoogleAuthAccountPipe::class,
            ConfirmGoogleAuthProfilePipe::class,
            ConfirmBonusPipe::class,
            ConfirmJwtPipe::class,
            ConfirmMailPipe::class,
        ], $dto);
    }
}
