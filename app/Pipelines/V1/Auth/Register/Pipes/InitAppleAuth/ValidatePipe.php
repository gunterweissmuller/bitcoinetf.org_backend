<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\InitAppleAuth;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitApplePipelineDto;
use App\Enums\Users\Email\StatusEnum;
use App\Exceptions\Pipelines\V1\Auth\UserAlreadyExistException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\AccountService;
use App\Services\Api\V1\Users\AppleAccountService;
use Closure;

final class ValidatePipe implements PipeInterface
{
    public function __construct(
        private readonly AccountService $accountService,
        private readonly AppleAccountService $appleAccountService,
    ) {
    }

    public function handle(InitApplePipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($appleAccount = $this->appleAccountService->get([
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
            $dto->setIsExists(true);
        } else {
            $dto->setIsExists(false);
        }

        return $next($dto);
    }
}
