<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\Init;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitApplePipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitFacebookPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitMetamaskPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitTelegramPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitWalletConnectPipelineDto;
use App\Enums\Users\Email\StatusEnum;
use App\Exceptions\Pipelines\V1\Auth\EmailAlreadyUseException;
use App\Exceptions\Pipelines\V1\Auth\UserAlreadyExistException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\AccountService;
use App\Services\Api\V1\Users\AppleAccountService;
use App\Services\Api\V1\Users\EmailService;
use App\Services\Api\V1\Users\FacebookService;
use App\Services\Api\V1\Users\TelegramService;
use App\Services\Api\V1\Users\WalletConnectService;
use App\Services\Api\V1\Users\WalletService;
use Closure;

final class ValidatePipe implements PipeInterface
{
    public function __construct(
        private readonly EmailService         $emailService,
        private readonly AccountService       $accountService,
        private readonly WalletService        $walletService,
        private readonly AppleAccountService  $appleAccountService,
        private readonly TelegramService      $telegramService,
        private readonly FacebookService      $facebookService,
        private readonly WalletConnectService $walletConnectService,
    )
    {
    }

    public function handle(InitPipelineDto|InitMetamaskPipelineDto|InitApplePipelineDto|InitTelegramPipelineDto|InitFacebookPipelineDto|InitWalletConnectPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $isExist = false;

        if ($email = $this->emailService->get([
            'email' => $dto->getEmail()->getEmail(),
        ])) {
            if ($account = $this->accountService->get([
                'uuid' => $email->getAccountUuid(),
            ])) {
                if ($email->getStatus() == StatusEnum::Enabled->value
                    || $email->getStatus() == StatusEnum::Disabled->value) {
                    throw new EmailAlreadyUseException();
                }

                /*                if ($account->getFastReg()) {
                                    if (
                                        ($email->getStatus() == StatusEnum::Enabled->value
                                            || $email->getStatus() == StatusEnum::Disabled->value)
                                        && $account->getFastPayment()
                                    ) {
                                        throw new EmailAlreadyUseException();
                                    }
                                } else {
                                    if ($email->getStatus() == StatusEnum::Enabled->value
                                        || $email->getStatus() == StatusEnum::Disabled->value) {
                                        throw new EmailAlreadyUseException();
                                    }
                                }*/
            }

            $dto->setEmail($email);
            $dto->setAccount($account);
            $isExist = true;
        }

        if (($dto instanceof InitMetamaskPipelineDto) && $wallet = $this->walletService->get([
                'wallet' => $dto->getWallet()->getWallet(),
            ])) {
            if ($account = $this->accountService->get([
                'uuid' => $wallet->getAccountUuid(),
            ])) {
                if ($account->getStatus() == StatusEnum::Enabled->value
                    || $account->getStatus() == StatusEnum::Disabled->value) {
                    throw new UserAlreadyExistException();
                }
            }

            $dto->setWallet($wallet);
            $dto->setAccount($account);
            $isExist = true;
        }

        if (($dto instanceof InitApplePipelineDto) && $appleAccount = $this->appleAccountService->get([
                'apple_id' => $dto->getAppleAccount()->getAppleId(),
            ])) {
            if ($account = $this->accountService->get([
                'uuid' => $appleAccount->getAccountUuid(),
            ])) {
                if ($appleAccount->getStatus() == StatusEnum::Enabled->value
                    || $appleAccount->getStatus() == StatusEnum::Disabled->value) {
                    throw new UserAlreadyExistException();
                }
            }

            $dto->setAppleAccount($appleAccount);
            $dto->setAccount($account);
            $isExist = true;
        }

        if (($dto instanceof InitTelegramPipelineDto) && $telegram = $this->telegramService->get([
                'telegram_id' => $dto->getTelegram()->getTelegramId(),
            ])) {
            if ($account = $this->accountService->get([
                'uuid' => $telegram->getAccountUuid(),
            ])) {
                if ($account->getStatus() == StatusEnum::Enabled->value
                    || $account->getStatus() == StatusEnum::Disabled->value) {
                    throw new UserAlreadyExistException();
                }
            }

            $dto->setTelegram($telegram);
            $dto->setAccount($account);
            $isExist = true;
        }

        if (($dto instanceof InitFacebookPipelineDto) && $facebook = $this->facebookService->get([
                'facebook_id' => $dto->getFacebook()->getFacebookId(),
            ])) {
            if ($account = $this->accountService->get([
                'uuid' => $facebook->getAccountUuid(),
            ])) {
                if ($account->getStatus() == StatusEnum::Enabled->value
                    || $account->getStatus() == StatusEnum::Disabled->value) {
                    throw new UserAlreadyExistException();
                }
            }

            $dto->setFacebook($facebook);
            $dto->setAccount($account);
            $isExist = true;
        }

        if (($dto instanceof InitWalletConnectPipelineDto) && $walletConnect = $this->walletConnectService->get([
                'address' => $dto->getWalletConnect()->getAddress(),
            ])) {
            if ($account = $this->accountService->get([
                'uuid' => $walletConnect->getAccountUuid(),
            ])) {
                if ($account->getStatus() == StatusEnum::Enabled->value
                    || $account->getStatus() == StatusEnum::Disabled->value) {
                    throw new UserAlreadyExistException();
                }
            }

            $dto->setWalletConnect($walletConnect);
            $dto->setAccount($account);
            $isExist = true;
        }

        $dto->setIsExists($isExist);
        return $next($dto);
    }
}
