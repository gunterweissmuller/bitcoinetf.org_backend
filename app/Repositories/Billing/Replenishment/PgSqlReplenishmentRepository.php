<?php

declare(strict_types=1);

namespace App\Repositories\Billing\Replenishment;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Billing\ReplenishmentDto;
use App\Models\Billing\Replenishment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class PgSqlReplenishmentRepository implements ReplenishmentRepositoryInterface
{
    public function __construct(
        private readonly Replenishment $model
    ) {
    }

    public function create(ReplenishmentDto $dto): ReplenishmentDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return ReplenishmentDto::fromArray($model->toArray());
    }

    public function get(array $filters, callable $callback = null): ?ReplenishmentDto
    {
        $model = $this->model
            ->newQuery()
            ->where($callback)
            ->where($filters)
            ->first();

        return $model ? ReplenishmentDto::fromArray($model->toArray()) : null;
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
            return ReplenishmentDto::fromArray($row);
        }) : null;
    }

    public function delete(array $condition): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->delete();
    }

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator
    {
        return $this->model
            ->newQuery()
            ->where($dto->getFilters() ?? [])
            ->orderBy('created_at', 'desc')
            ->paginate($dto->getPerPage(), ['*'], 'page', $dto->getPage());
    }
}
