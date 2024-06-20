<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Public\Newsletter;

use App\Dto\DtoInterface;
use App\Dto\Models\Newsletter\SubscriptionDto;

final class SubscribePipelineDto implements DtoInterface
{
    /**
     * @param SubscriptionDto|null $subscription
     */
    public function __construct(
        private ?SubscriptionDto $subscription,
    )
    {
    }

    /**
     * @param array $args
     * @return DtoInterface|self
     */
    public static function fromArray(array $args): DtoInterface|self
    {
        return new self($args['subscription'] ?? null);
    }

    /**
     * @return SubscriptionDto[]|null[]
     */
    public function toArray(): array
    {
        return ['subscription' => $this->subscription,];
    }

    /**
     * @return SubscriptionDto|null
     */
    public function getSubscription(): ?SubscriptionDto
    {
        return $this->subscription;
    }

    /**
     * @param SubscriptionDto|null $subscription
     * @return void
     */
    public function setSubscription(?SubscriptionDto $subscription): void
    {
        $this->subscription = $subscription;
    }
}
