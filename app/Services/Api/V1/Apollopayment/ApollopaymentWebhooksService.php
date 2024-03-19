<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Apollopayment;


use App\Dto\Models\Apollopayment\WebhooksDto;
use App\Repositories\Apollopayment\Webhooks\WebhooksRepositoryInterface;

final class ApollopaymentWebhooksService
{
    public function __construct(
        private readonly WebhooksRepositoryInterface $repository,
    ) {
    }

    public function create(WebhooksDto $dto): WebhooksDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?WebhooksDto
    {
        return $this->repository->get($filters);
    }

    public function update(array $condition, array $data): void
    {
        $this->repository->update($condition, $data);
    }

    public function delete(array $condition): void
    {
        $this->repository->delete($condition);
    }

    public function createWebhook(
        string $client_id,
        string $webhook_id,
        string $address_id,
        float $amount,
        string $currency,
        string $network,
        string $tx,
        string $type
        ): WebhooksDto
    {
        $dto = new WebhooksDto(
            null,
            $client_id,
            $webhook_id,
            $address_id,
            $amount,
            $currency,
            $network,
            $tx,
            $type,
        );
        return $this->repository->create($dto);
    }
}
