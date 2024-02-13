<?php

declare(strict_types=1);

namespace App\Repositories\Kyc\FieldOption;

use App\Dto\Models\Kyc\FieldOptionDto;
use App\Models\Kyc\FieldOption;
use Illuminate\Support\Collection;

final class PgSqlFieldOptionRepository implements FieldOptionRepositoryInterface
{
    public function __construct(
        private readonly FieldOption $model,
    ) {
    }

    public function create(FieldOptionDto $dto): FieldOptionDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return FieldOptionDto::fromArray($model->toArray());
    }

    public function get(array $filters, array $order = []): ?FieldOptionDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->orderBy('created_at', 'desc')
            ->first();

        return $model ? FieldOptionDto::fromArray($model->toArray()) : null;
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
            return FieldOptionDto::fromArray($row);
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
