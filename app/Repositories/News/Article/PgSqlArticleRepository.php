<?php

declare(strict_types=1);

namespace App\Repositories\News\Article;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\News\ArticleDto;
use App\Models\News\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class PgSqlArticleRepository implements ArticleRepositoryInterface
{
    public function __construct(
        private readonly Article $model,
    ) {
    }

    public function create(ArticleDto $dto): ArticleDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return ArticleDto::fromArray($model->toArray());
    }

    public function get(array $filters): ?ArticleDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? ArticleDto::fromArray($model->toArray()) : null;
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
            return ArticleDto::fromArray($row);
        }) : null;
    }

    public function delete(array $condition): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->delete();
    }

    public function allByFilters(PaginationFilterDto $dto, callable $callback = null): LengthAwarePaginator
    {
        return $this->model
            ->newQuery()
            ->where($callback)
            ->where($dto->getFilters() ?? [])
            ->orderBy($dto->getOrderColumn() ?? 'created_at', $dto->getOrderBy() ?? 'desc')
            ->paginate($dto->getPerPage(), ['*'], 'page', $dto->getPage());
    }
}
