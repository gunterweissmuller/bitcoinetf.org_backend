<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\ConfirmFacebookAuth;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmFacebookPipelineDto;
use App\Enums\Users\Email\StatusEnum as StatusEnumEmail;
use App\Enums\Users\Facebook\StatusEnum as StatusEnumFacebook;
use App\Exceptions\Pipelines\V1\Auth\EmailAlreadyUseException;
use App\Exceptions\Pipelines\V1\Auth\EmailNotFoundException;
use App\Exceptions\Pipelines\V1\Auth\UserAlreadyExistException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\AccountService;
use App\Services\Api\V1\Users\EmailService;
use App\Services\Api\V1\Users\FacebookService;
use Closure;

final class ValidatePipe implements PipeInterface
{
    public function __construct(
        private readonly EmailService    $emailService,
        private readonly AccountService  $accountService,
        private readonly FacebookService $facebookService,
    )
    {
    }

    public function handle(ConfirmFacebookPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
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
            if (!$this->facebookService->get([
                'account_uuid' => $email->getAccountUuid(),
                'status' => StatusEnumFacebook::AwaitConfirm->value,
            ])) {
                throw new UserAlreadyExistException();
            }
        } else {
            throw new EmailNotFoundException();
        }

        return $next($dto);
    }
}
