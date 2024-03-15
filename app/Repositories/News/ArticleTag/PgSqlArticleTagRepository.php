<?php

declare(strict_types=1);

namespace App\Repositories\News\ArticleTag;

use App\Dto\Models\News\ArticleTagDto;
use App\Models\News\ArticleTag;
use Illuminate\Support\Collection;

final class PgSqlArticleTagRepository implements ArticleTagRepositoryInterface
{
    public function __construct(
        private readonly ArticleTag $model,
    ) {
    }

    public function create(ArticleTagDto $dto): ArticleTagDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return ArticleTagDto::fromArray($model->toArray());
    }

    public function get(array $filters): ?ArticleTagDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? ArticleTagDto::fromArray($model->toArray()) : null;
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
            return ArticleTagDto::fromArray($row);
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
