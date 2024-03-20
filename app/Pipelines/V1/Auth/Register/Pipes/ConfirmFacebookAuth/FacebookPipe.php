<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\ConfirmFacebookAuth;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmFacebookPipelineDto;
use App\Enums\Users\Facebook\StatusEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\FacebookService;
use Closure;

final class FacebookPipe implements PipeInterface
{
    public function __construct(
        private readonly FacebookService $facebookService,
    )
    {
    }

    public function handle(ConfirmFacebookPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($facebook = $this->facebookService->get(['facebook_id' => $dto->getFacebook()->getFacebookId()])) {
            $facebook->setStatus(StatusEnum::Enabled->value);

            $this->facebookService->update([
                'facebook_id' => $facebook->getFacebookId(),
            ], [
                'status' => $facebook->getStatus(),
            ]);
            $dto->setFacebook($facebook);
        }

        return $next($dto);
    }
}
