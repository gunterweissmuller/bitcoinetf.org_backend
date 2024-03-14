<?php

declare(strict_types=1);

namespace App\Repositories\Auth\Code;

use App\Dto\Models\Auth\CodeDto;
use App\Models\Auth\Code;
use Illuminate\Support\Collection;

final class PgSqlCodeRepository implements CodeRepositoryInterface
{
    public function __construct(
        private readonly Code $model,
    ) {
    }

    public function create(CodeDto $dto): CodeDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return CodeDto::fromArray($model->toArray());
    }

    public function get(array $filters, array $order = []): ?CodeDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->orderBy('created_at', 'desc')
            ->first();

        return $model ? CodeDto::fromArray($model->toArray()) : null;
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
            return CodeDto::fromArray($row);
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
