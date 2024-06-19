<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Newsletter\Pipes\Subscribe;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Newsletter\SubscribePipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Newsletter\SubscriptionService;
use Closure;

final readonly class SubscribePipe implements PipeInterface
{
    /**
     * @param SubscriptionService $subscriptionService
     */
    public function __construct(
        private SubscriptionService $subscriptionService,
    )
    {
    }

    /**
     * @param SubscribePipelineDto|DtoInterface $dto
     * @param Closure $next
     * @return DtoInterface
     */
    public function handle(SubscribePipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if (!$this->subscriptionService->get([
            'email' => $dto->getSubscription()->getEmail(),
        ])) {
            $subscription = $this->subscriptionService->create($dto->getSubscription());
            $dto->setSubscription($subscription);
        }

        return $next($dto);
    }
}
