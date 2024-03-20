<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\AuthType\Pipes\CheckFacebook;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\AuthType\AuthTypeFacebookPipelineDto;
use App\Enums\Auth\AuthType\StatusEnum as AuthTypeStatusEnum;
use App\Enums\Users\Facebook\StatusEnum;
use App\Exceptions\Pipelines\V1\Auth\UserAlreadyExistException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\FacebookService;
use Closure;

final class ValidatePipe implements PipeInterface
{
    public function __construct(
        private readonly FacebookService $facebookService,
    ) {
    }

    public function handle(AuthTypeFacebookPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $facebook = $this->facebookService->get([
            'facebook_id' => $dto->getFacebook()->getFacebookId(),
        ]);

        if (!$facebook) {
            $dto->setAuthType(AuthTypeStatusEnum::Registration);
        } else if ($facebook->getStatus() === StatusEnum::AwaitConfirm->value) {
            $dto->setAuthType(AuthTypeStatusEnum::Registration);
        } else if ($facebook->getStatus() === StatusEnum::Enabled->value) {
            $dto->setAuthType(AuthTypeStatusEnum::Login);
        } else {
            throw new UserAlreadyExistException();
        }

        return $next($dto);
    }
}
