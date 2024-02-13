<?php

declare(strict_types=1);

namespace App\Repositories\Billing\Token;

use App\Models\Billing\Token;
use Illuminate\Support\Collection;
use App\Dto\Models\Billing\TokenDto;
use App\Dto\Core\PaginationFilterDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class PgSqlTokenRepository implements TokenRepositoryInterface
{
    public function __construct(
        private readonly Token $model,
    ) {
    }

    public function create(TokenDto $dto): TokenDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return TokenDto::fromArray($model->toArray());
    }

    public function get(array $filters): ?TokenDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? TokenDto::fromArray($model->toArray()) : null;
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
            return TokenDto::fromArray($row);
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
