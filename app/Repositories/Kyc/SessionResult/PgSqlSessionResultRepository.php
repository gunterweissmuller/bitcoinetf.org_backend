<?php

declare(strict_types=1);

namespace App\Repositories\Kyc\SessionResult;

use App\Dto\Models\Kyc\SessionResultDto;
use App\Models\Kyc\SessionResult;
use Illuminate\Support\Collection;

final class PgSqlSessionResultRepository implements SessionResultRepositoryInterface
{
    public function __construct(
        private readonly SessionResult $model,
    ) {
    }

    public function create(SessionResultDto $dto): SessionResultDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return SessionResultDto::fromArray($model->toArray());
    }

    public function get(array $filters, array $order = []): ?SessionResultDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->orderBy('created_at', 'desc')
            ->first();

        return $model ? SessionResultDto::fromArray($model->toArray()) : null;
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
            return SessionResultDto::fromArray($row);
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
