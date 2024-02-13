<?php

declare(strict_types=1);

namespace App\Repositories\Fund\Shareholder;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Fund\ShareholderDto;
use App\Models\Fund\Shareholder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class PgSqlShareholderRepository implements ShareholderRepositoryInterface
{
    public function __construct(private readonly Shareholder $model)
    {
    }

    public function create(ShareholderDto $dto): ShareholderDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return ShareholderDto::fromArray($model->toArray());
    }

    public function get(array $filters): ?ShareholderDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? ShareholderDto::fromArray($model->toArray()) : null;
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
            return ShareholderDto::fromArray($row);
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

    public function getTotalPayments(array $filters, callable $callback = null): float
    {
        return (float) $this->model
            ->newQuery()
            ->where($filters)
            ->where($callback)
            ->sum('total_payments');
    }

    public function getCount(array $filters): int
    {
        return $this->model
            ->newQuery()
            ->where($filters)
            ->count();
    }

    public function getTop(PaginationFilterDto $dto, array|string $select = '*'): LengthAwarePaginator
    {
        return $this->model
            ->newQuery()
            ->select($select)
            ->where($dto->getFilters() ?? [])
            ->orderBy($dto->getOrderColumn() ?? 'created_at', $dto->getOrderBy() ?? 'desc')
            ->with(['account:uuid,username,created_at'])
            ->paginate($dto->getPerPage(), ['*'], 'page', $dto->getPage());
    }
}
