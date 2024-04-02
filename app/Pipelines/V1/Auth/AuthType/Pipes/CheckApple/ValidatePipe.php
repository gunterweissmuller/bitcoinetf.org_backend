<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\AuthType\Pipes\CheckApple;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\AuthType\AuthTypeApplePipelineDto;
use App\Enums\Auth\AuthType\StatusEnum as AuthTypeStatusEnum;
use App\Enums\Users\AppleAccount\StatusEnum;
use App\Exceptions\Pipelines\V1\Auth\UserAlreadyExistException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\AppleAccountService;
use Closure;

final class ValidatePipe implements PipeInterface
{
    public function __construct(
        private readonly AppleAccountService $appleAccountService,
    ) {
    }

    public function handle(AuthTypeApplePipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $appleAccount = $this->appleAccountService->get([
            'apple_id' => $dto->getAppleAccount()->getAppleId(),
        ]);

        if (!$appleAccount) {
            $dto->setAuthType(AuthTypeStatusEnum::Registration);
        } else if ($appleAccount->getStatus() === StatusEnum::AwaitConfirm->value) {
            $dto->setAuthType(AuthTypeStatusEnum::Registration);
        } else if ($appleAccount->getStatus() === StatusEnum::Enabled->value) {
            $dto->setAuthType(AuthTypeStatusEnum::Login);
        } else {
            throw new UserAlreadyExistException();
        }

        return $next($dto);
    }
}
