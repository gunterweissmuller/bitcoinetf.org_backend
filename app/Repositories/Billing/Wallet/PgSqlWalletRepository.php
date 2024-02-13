<?php

declare(strict_types=1);

namespace App\Repositories\Billing\Wallet;

use App\Models\Billing\Wallet;
use Illuminate\Support\Collection;
use App\Dto\Models\Billing\WalletDto;
use App\Dto\Core\PaginationFilterDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class PgSqlWalletRepository implements WalletRepositoryInterface
{
    public function __construct(
        private readonly Wallet $model,
    ) {
    }

    public function create(WalletDto $dto): WalletDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return WalletDto::fromArray($model->toArray());
    }

    public function get(array $filters): ?WalletDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? WalletDto::fromArray($model->toArray()) : null;
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
            return WalletDto::fromArray($row);
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
