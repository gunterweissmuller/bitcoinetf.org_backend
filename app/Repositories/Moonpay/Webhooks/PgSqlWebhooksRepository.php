<?php

declare(strict_types=1);

namespace App\Repositories\Moonpay\Webhooks;

use App\Dto\Models\Moonpay\WebhooksDto;
use App\Models\Moonpay\Webhooks;

final class PgSqlWebhooksRepository implements WebhooksRepositoryInterface
{
    public function __construct(
        private readonly Webhooks $model,
    ) {
    }

    public function create(WebhooksDto $dto): WebhooksDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return WebhooksDto::fromArray($model->toArray());
    }

    public function get(array $filters): ?WebhooksDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? WebhooksDto::fromArray($model->toArray()) : null;
    }

    public function update(array $condition, array $data): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->update($data);
    }

    public function delete(array $condition): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->delete();
    }
}
