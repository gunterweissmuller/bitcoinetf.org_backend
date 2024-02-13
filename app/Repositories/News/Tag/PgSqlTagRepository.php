<?php

declare(strict_types=1);

namespace App\Repositories\News\Tag;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\News\TagDto;
use App\Models\News\Tag;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class PgSqlTagRepository implements TagRepositoryInterface
{
    public function __construct(
        private readonly Tag $model,
    ) {
    }

    public function create(TagDto $dto): TagDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return TagDto::fromArray($model->toArray());
    }

    public function get(array $filters): ?TagDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? TagDto::fromArray($model->toArray()) : null;
    }

    public function update(array $condition, array $data): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->update($data);
    }

    public function all(array $filters, callable $callback = null): ?Collection
    {
        $rows = $this->model
            ->newQuery()
            ->where($filters)
            ->where($callback)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();

        return $rows ? Collection::make($rows)->map(function (array $row) {
            return TagDto::fromArray($row);
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
            ->orderBy($dto->getOrderColumn() ?? 'created_at', $dto->getOrderBy() ?? 'desc')
            ->paginate($dto->getPerPage(), ['*'], 'page', $dto->getPage());
    }
}
