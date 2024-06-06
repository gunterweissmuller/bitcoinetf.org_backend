<?php

declare(strict_types=1);

namespace App\Repositories\Billing\Sell;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Billing\SellDto;
use App\Models\Billing\Sell;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class PgSqlSellRepository implements SellRepositoryInterface
{
    public function __construct(
        private readonly Sell $model
    ) {
    }

    public function create(SellDto $dto): SellDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return SellDto::fromArray($model->toArray());
    }

    public function get(array $filters): ?SellDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? SellDto::fromArray($model->toArray()) : null;
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
            return SellDto::fromArray($row);
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

    public function allByFiltersWithChunk(array $filters, int $count, callable $callback): void
    {
        $this->model
            ->newQuery()
            ->where($filters)
            ->orderBy('created_at', 'desc')
            ->chunk($count, $callback);
    }

}
