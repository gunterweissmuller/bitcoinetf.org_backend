<?php

declare(strict_types=1);

namespace App\Repositories\Kyc\Screen;

use App\Dto\Models\Kyc\ScreenDto;
use App\Models\Kyc\Screen;
use Illuminate\Support\Collection;

final class PgSqlScreenRepository implements ScreenRepositoryInterface
{
    public function __construct(
        private readonly Screen $model,
    ) {
    }

    public function create(ScreenDto $dto): ScreenDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return ScreenDto::fromArray($model->toArray());
    }

    public function get(array $filters, array $order = []): ?ScreenDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->orderBy('sort')
            ->first();

        return $model ? ScreenDto::fromArray($model->toArray()) : null;
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
            return ScreenDto::fromArray($row);
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
