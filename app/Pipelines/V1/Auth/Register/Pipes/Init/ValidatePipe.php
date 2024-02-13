<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\Init;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitPipelineDto;
use App\Enums\Users\Email\StatusEnum;
use App\Exceptions\Pipelines\V1\Auth\EmailAlreadyUseException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\AccountService;
use App\Services\Api\V1\Users\EmailService;
use Closure;

final class ValidatePipe implements PipeInterface
{
    public function __construct(
        private readonly EmailService $emailService,
        private readonly AccountService $accountService,
    ) {
    }

    public function handle(InitPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
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
            $dto->setIsExists(true);
        } else {
            $dto->setIsExists(false);
        }

        return $next($dto);
    }
}
