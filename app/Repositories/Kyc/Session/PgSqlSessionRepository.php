<?php

declare(strict_types=1);

namespace App\Repositories\Kyc\Session;

use App\Dto\Models\Kyc\SessionDto;
use App\Models\Kyc\Session;
use Illuminate\Support\Collection;

final class PgSqlSessionRepository implements SessionRepositoryInterface
{
    public function __construct(
        private readonly Session $model,
    ) {
    }

    public function create(SessionDto $dto): SessionDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return SessionDto::fromArray($model->toArray());
    }

    public function get(array $filters, array $order = []): ?SessionDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->orderBy('created_at', 'desc')
            ->first();

        return $model ? SessionDto::fromArray($model->toArray()) : null;
    }

    public function update(array $condition, array $data): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->update($data);
    }

    public function all(array $filters): ?Collection
    {
        $rows = $this->model
            ->newQuery()
            ->where($filters)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();

        return $rows ? Collection::make($rows)->map(function (array $row) {
            return SessionDto::fromArray($row);
        }) : null;
    }

    public function delete(array $condition): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->delete();
    }
}
