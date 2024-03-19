<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Login\Pipes\LoginFacebook;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginFacebookPipelineDto;
use App\Enums\Users\Facebook\StatusEnum;
use App\Exceptions\Pipelines\V1\Auth\IncorrectLoginDataException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\FacebookService;
use Closure;

final class FacebookPipe implements PipeInterface
{
    public function __construct(
        private readonly FacebookService $facebookService
    )
    {
    }

    public function handle(LoginFacebookPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($facebook = $this->facebookService->get([
            'facebook_id' => $dto->getFacebook()->getFacebookId(),
            'status' => StatusEnum::Enabled->value,
        ])) {
            $dto->setFacebook($facebook);
        } else {
            throw new IncorrectLoginDataException();
        }

        return $next($dto);
    }
}
