<?php

declare(strict_types=1);

namespace App\Repositories\Auth\RefreshToken;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Auth\RefreshTokenDto;
use App\Models\Auth\RefreshToken;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class PgSqlRefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    public function __construct(
        private readonly RefreshToken $model,
    ) {
    }

    public function create(RefreshTokenDto $dto): RefreshTokenDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return RefreshTokenDto::fromArray($model->toArray());
    }

    public function get(array $filters): ?RefreshTokenDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? RefreshTokenDto::fromArray($model->toArray()) : null;
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
            return RefreshTokenDto::fromArray($row);
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
            ->orderBy('created_at', 'desc')
            ->paginate($dto->getPerPage(), ['*'], 'page', $dto->getPage());
    }
}
