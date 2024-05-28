<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\ConfirmWalletConnectAuth;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmWalletConnectPipelineDto;
use App\Enums\Users\Email\StatusEnum as StatusEnumEmail;
use App\Enums\Users\WalletConnect\StatusEnum as StatusEnumWalletConnect;
use App\Exceptions\Pipelines\V1\Auth\EmailAlreadyUseException;
use App\Exceptions\Pipelines\V1\Auth\EmailNotFoundException;
use App\Exceptions\Pipelines\V1\Auth\UserAlreadyExistException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\AccountService;
use App\Services\Api\V1\Users\EmailService;
use App\Services\Api\V1\Users\WalletConnectService;
use Closure;

final class ValidatePipe implements PipeInterface
{
    /**
     * @param EmailService $emailService
     * @param AccountService $accountService
     * @param WalletConnectService $walletConnectService
     */
    public function __construct(
        private readonly EmailService $emailService,
        private readonly AccountService $accountService,
        private readonly WalletConnectService $walletConnectService,
    ) {
    }

    /**
     * @param ConfirmWalletConnectPipelineDto|DtoInterface $dto
     * @param Closure $next
     * @return DtoInterface
     */
    public function handle(ConfirmWalletConnectPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($email = $this->emailService->get([
            'email' => $dto->getEmail()->getEmail(),
        ])) {
            if (!$this->accountService->get([
                'uuid' => $email->getAccountUuid(),
                'status' => StatusEnumEmail::AwaitConfirm->value,
            ])) {
                throw new EmailAlreadyUseException();
            }
            if (!$this->walletConnectService->get([
                'account_uuid' => $email->getAccountUuid(),
                'status' => StatusEnumWalletConnect::AwaitConfirm->value,
            ])) {
                throw new UserAlreadyExistException();
            }
        } else {
            throw new EmailNotFoundException();
        }

        return $next($dto);
    }
}
