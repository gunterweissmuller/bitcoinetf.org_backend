<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\ConfirmGoogleAuth;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmGooglePipelineDto;
use App\Enums\Users\Email\StatusEnum;
use App\Exceptions\Pipelines\V1\Auth\EmailAlreadyUseException;
use App\Exceptions\Pipelines\V1\Auth\EmailNotFoundException;
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

    public function handle(ConfirmGooglePipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($email = $this->emailService->get([
            'email' => $dto->getEmail()->getEmail(),
        ])) {
            if (!$this->accountService->get([
                'uuid' => $email->getAccountUuid(),
                'status' => StatusEnum::AwaitConfirm->value,
            ])) {
                throw new EmailAlreadyUseException();
            }
        } else {
            throw new EmailNotFoundException();
        }

        return $next($dto);
    }
}
