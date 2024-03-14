<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register;

use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmApplePipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmGooglePipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmMetamaskPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitApplePipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmTelegramPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitGooglePipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitMetamaskPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitTelegramPipelineDto;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\V1\Auth\Register\Pipes\Confirm\AccountPipe as ConfirmAccountPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Confirm\BonusPipe as ConfirmBonusPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Confirm\CodePipe as ConfirmCodePipe;
use App\Pipelines\V1\Auth\Register\Pipes\Confirm\EmailPipe as ConfirmEmailPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Confirm\JwtPipe as ConfirmJwtPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Confirm\MailPipe as ConfirmMailPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Confirm\UpdateUsersInfoPipe as ConfirmUpdateUsersInfoPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Confirm\ValidatePipe as ConfirmValidatePipe;
use App\Pipelines\V1\Auth\Register\Pipes\ConfirmGoogleAuth\AccountPipe as ConfirmGoogleAuthAccountPipe;
use App\Pipelines\V1\Auth\Register\Pipes\ConfirmGoogleAuth\ProfilePipe as ConfirmGoogleAuthProfilePipe;
use App\Pipelines\V1\Auth\Register\Pipes\ConfirmMetamaskAuth\AccountPipe as ConfirmMetamaskAccountPipe;
use App\Pipelines\V1\Auth\Register\Pipes\ConfirmAppleAuth\AccountPipe as ConfirmAppleAuthAccountPipe;
use App\Pipelines\V1\Auth\Register\Pipes\ConfirmTelegramAuth\AccountPipe as ConfirmTelegramAccountPipe;
use App\Pipelines\V1\Auth\Register\Pipes\ConfirmTelegramAuth\TelegramPipe as ConfirmTelegramPipe;
use App\Pipelines\V1\Auth\Register\Pipes\ConfirmTelegramAuth\ValidatePipe as ConfirmTelegramValidatePipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\AccountPipe as InitAccountPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\ApolloClientPipe as InitApolloClientPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\AppleAccountPipe as InitAppleAuthAppleAccountPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\BonusPipe as InitBonusPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\EmailPipe as InitEmailPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\InvitePipe as InitInvitePipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\KafkaEventPipe as InitKafkaEventPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\NewCodePipe as InitNewCodePipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\ProfilePipe as InitProfilePipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\TelegramPipe as InitTelegramPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\TronWalletPipe as InitTronWalletPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\UserEventPipe as InitUserEventPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\UserWalletPipe as InitMetamaskWalletPipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\ValidatePipe as InitValidatePipe;
use App\Pipelines\V1\Auth\Register\Pipes\Init\WalletPipe as InitWalletPipe;


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
            InitApolloClientPipe::class,
            InitNewCodePipe::class,
            InitBonusPipe::class,
            InitKafkaEventPipe::class,
            InitUserEventPipe::class,
        ], $dto);
    }

    public function confirm(ConfirmPipelineDto $dto): array
    {
        return $this->pipeline([
            ConfirmValidatePipe::class,
            ConfirmEmailPipe::class,
            ConfirmCodePipe::class,
            ConfirmAccountPipe::class,
            ConfirmBonusPipe::class,
            ConfirmJwtPipe::class,
            ConfirmMailPipe::class,
            ConfirmUpdateUsersInfoPipe::class,
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
            InitKafkaEventPipe::class,
        ], $dto);
    }

    public function confirmGoogleAuth(ConfirmGooglePipelineDto $dto): array
    {
        return $this->pipeline([
            ConfirmValidatePipe::class,
            ConfirmEmailPipe::class,
            ConfirmGoogleAuthAccountPipe::class,
            ConfirmGoogleAuthProfilePipe::class,
            ConfirmBonusPipe::class,
            ConfirmJwtPipe::class,
            ConfirmMailPipe::class,
            ConfirmUpdateUsersInfoPipe::class,
        ], $dto);
    }

    public function initMetamaskAuth(InitMetamaskPipelineDto $dto): array
    {
        return $this->pipeline([
            InitValidatePipe::class,
            InitAccountPipe::class,
            InitEmailPipe::class,
            InitProfilePipe::class,
            InitMetamaskWalletPipe::class,
            InitWalletPipe::class,
            InitInvitePipe::class,
            InitTronWalletPipe::class,
            InitNewCodePipe::class,
            InitBonusPipe::class,
            InitKafkaEventPipe::class,
            InitUserEventPipe::class,
        ], $dto);
    }

    public function confirmMetamaskAuth(ConfirmMetamaskPipelineDto $dto): array
    {
        return $this->pipeline([
            ConfirmValidatePipe::class,
            ConfirmEmailPipe::class,
            ConfirmCodePipe::class,
            ConfirmMetamaskAccountPipe::class,
            ConfirmBonusPipe::class,
            ConfirmJwtPipe::class,
            ConfirmMailPipe::class,
            ConfirmUpdateUsersInfoPipe::class,
        ], $dto);
    }

    public function initAppleAuth(InitApplePipelineDto $dto): array
    {
        return $this->pipeline([
            InitValidatePipe::class,
            InitAccountPipe::class,
            InitEmailPipe::class,
            InitProfilePipe::class,
            InitAppleAuthAppleAccountPipe::class,
            InitWalletPipe::class,
            InitInvitePipe::class,
            InitTronWalletPipe::class,
            InitNewCodePipe::class,
            InitBonusPipe::class,
            InitKafkaEventPipe::class,
            InitUserEventPipe::class,
        ], $dto);
    }

    public function confirmAppleAuth(ConfirmApplePipelineDto $dto): array
    {
        return $this->pipeline([
            ConfirmValidatePipe::class,
            ConfirmEmailPipe::class,
            ConfirmCodePipe::class,
            ConfirmAppleAuthAccountPipe::class,
            ConfirmBonusPipe::class,
            ConfirmJwtPipe::class,
            ConfirmMailPipe::class,
            ConfirmUpdateUsersInfoPipe::class,
        ], $dto);
    }

    public function initTelegramAuth(InitTelegramPipelineDto $dto): array
    {
        return $this->pipeline([
            InitValidatePipe::class,
            InitAccountPipe::class,
            InitEmailPipe::class,
            InitProfilePipe::class,
            InitTelegramPipe::class,
            InitWalletPipe::class,
            InitInvitePipe::class,
            InitTronWalletPipe::class,
            InitNewCodePipe::class,
            InitBonusPipe::class,
            InitKafkaEventPipe::class,
            InitUserEventPipe::class,
        ], $dto);
    }

    public function confirmTelegramAuth(ConfirmTelegramPipelineDto $dto): array
    {
        return $this->pipeline([
            ConfirmTelegramValidatePipe::class,
            ConfirmEmailPipe::class,
            ConfirmCodePipe::class,
            ConfirmTelegramAccountPipe::class,
            ConfirmTelegramPipe::class,
            ConfirmBonusPipe::class,
            ConfirmJwtPipe::class,
            ConfirmMailPipe::class,
            ConfirmUpdateUsersInfoPipe::class,
        ], $dto);
    }
}
