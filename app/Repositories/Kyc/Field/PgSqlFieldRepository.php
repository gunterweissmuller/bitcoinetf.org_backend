<?php

declare(strict_types=1);

namespace App\Repositories\Kyc\Field;

use App\Dto\Models\Kyc\FieldDto;
use App\Models\Kyc\Field;
use Illuminate\Support\Collection;

final class PgSqlFieldRepository implements FieldRepositoryInterface
{
    public function __construct(
        private readonly Field $model,
    ) {
    }

    public function create(FieldDto $dto): FieldDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return FieldDto::fromArray($model->toArray());
    }

    public function get(array $filters, array $order = []): ?FieldDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->orderBy('sort')
            ->first();

        return $model ? FieldDto::fromArray($model->toArray()) : null;
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
            ->orderBy('sort')
            ->get()
            ->toArray();

        return $rows ? Collection::make($rows)->map(function (array $row) {
            return FieldDto::fromArray($row);
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
