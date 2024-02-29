<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\Init;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitMetamaskPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitTelegramPipelineDto;
use App\Enums\Users\Email\StatusEnum;
use App\Exceptions\Pipelines\V1\Auth\EmailAlreadyUseException;
use App\Exceptions\Pipelines\V1\Auth\IncorrectCodeException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\AccountService;
use App\Services\Api\V1\Users\EmailService;
use App\Services\Api\V1\Users\TelegramService;
use App\Services\Api\V1\Users\WalletService;
use Closure;

final class ValidatePipe implements PipeInterface
{
    public function __construct(
        private readonly EmailService $emailService,
        private readonly AccountService $accountService,
        private readonly WalletService $walletService,
        private readonly TelegramService $telegramService,
    ) {
    }

    public function handle(InitPipelineDto|InitMetamaskPipelineDto|InitTelegramPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $isExist = false;

        if ($email = $this->emailService->get([
            'email' => $dto->getEmail()->getEmail(),
        ])) {
            if ($account = $this->accountService->get([
                'uuid' => $email->getAccountUuid(),
            ])) {
                if ($account->getFastReg()) {
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
                }
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
                    throw new IncorrectCodeException();
                }
            }

            $dto->setWallet($wallet);
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
                    throw new IncorrectCodeException();
                }
            }

            $dto->setTelegram($telegram);
            $dto->setAccount($account);
            $isExist = true;
        }

        $dto->setIsExists($isExist);
        return $next($dto);
    }
}
