<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\Init;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitFacebookPipelineDto;
use App\Enums\Users\Facebook\StatusEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\FacebookService;
use Closure;

final class FacebookPipe implements PipeInterface
{
    public function __construct(
        private readonly FacebookService $facebookService,
    ) {
    }

    public function handle(InitFacebookPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if (!$facebook = $this->facebookService->get([
            'facebook_id' => $dto->getFacebook()->getFacebookId(),
        ])) {
            $facebook = $dto->getFacebook();
            $facebook->setAccountUuid($dto->getAccount()->getUuid());
            $facebook->setStatus(StatusEnum::AwaitConfirm->value);
            $facebook->setFacebookId($dto->getFacebook()->getFacebookId());

            $facebook = $this->facebookService->create($facebook);
        }

        $dto->setFacebook($facebook);
        return $next($dto);
    }
}
