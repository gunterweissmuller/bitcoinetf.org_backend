<?php

declare(strict_types=1);

namespace App\Services\Api\V3\Apollopayment;


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
}
