<?php

declare(strict_types=1);

namespace App\Repositories\Apollopayment\Clients;

use App\Dto\Models\Apollopayment\ClientsDto;
use App\Models\Apollopayment\Clients;

final class PgSqlClientsRepository implements ClientsRepositoryInterface
{
    public function __construct(
        private readonly Clients $model,
    )
    {
    }

    public function create(ClientsDto $dto): ClientsDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return ClientsDto::fromArray($model->toArray());
    }

    public function get(array $filters): ?ClientsDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? ClientsDto::fromArray($model->toArray()) : null;
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

    public function allByFiltersWithChunk(array $filters, int $count, callable $callback): void
    {
        $this->model
            ->newQuery()
            ->where($filters)
            ->orderBy('created_at', 'desc')
            ->chunk($count, $callback);
    }

    public function deleteDuplicate(array $condition, string $uuid): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->where('uuid', '!=', $uuid)
            ->delete();
    }
}
