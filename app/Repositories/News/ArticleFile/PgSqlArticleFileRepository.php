<?php

declare(strict_types=1);

namespace App\Repositories\News\ArticleFile;

use App\Dto\Models\News\ArticleFileDto;
use App\Models\News\ArticleFile;
use Illuminate\Support\Collection;

final class PgSqlArticleFileRepository implements ArticleFileRepositoryInterface
{
    public function __construct(
        private readonly ArticleFile $model,
    ) {
    }

    public function create(ArticleFileDto $dto): ArticleFileDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return ArticleFileDto::fromArray($model->toArray());
    }

    public function get(array $filters): ?ArticleFileDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? ArticleFileDto::fromArray($model->toArray()) : null;
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
            return ArticleFileDto::fromArray($row);
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
