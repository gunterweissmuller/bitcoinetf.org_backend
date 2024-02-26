<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\InitMetamaskAuth;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitMetamaskPipelineDto;
use App\Enums\Users\Email\StatusEnum;
use App\Exceptions\Pipelines\V1\Auth\EmailAlreadyUseException;
use App\Exceptions\Pipelines\V1\Auth\IncorrectCodeException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\AccountService;
use App\Services\Api\V1\Users\EmailService;
use App\Services\Api\V1\Users\WalletService;
use Closure;

final class ValidatePipe implements PipeInterface
{
    public function __construct(
        private readonly EmailService $emailService,
        private readonly AccountService $accountService,
        private readonly WalletService $walletService,
    ) {
    }

    public function handle(InitMetamaskPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
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
            }

            $dto->setEmail($email);
            $dto->setIsExistsEmail(true);
        } else {
            $dto->setIsExistsEmail(false);
        }

        if ($wallet = $this->walletService->get([
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
            $dto->setIsExistsWallet(true);
        } else {
            $dto->setIsExistsWallet(false);
        }

        return $next($dto);
    }
}
