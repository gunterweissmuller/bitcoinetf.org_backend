<?php

declare(strict_types=1);

namespace App\Services\Api\V1\News;

use App\Dto\Models\News\ArticleTagDto;
use App\Repositories\News\ArticleTag\PgSqlArticleTagRepository;
use Illuminate\Support\Collection;

final class ArticleTagService
{
    public function __construct(
        private readonly PgSqlArticleTagRepository $repository,
    ) {
    }

    public function create(ArticleTagDto $dto): ArticleTagDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?ArticleTagDto
    {
        return $this->repository->get($filters);
    }

    public function update(array $condition, array $data): void
    {
        $this->repository->update($condition, $data);
    }

    public function all(array $filters): ?Collection
    {
        return $this->repository->all($filters);
    }

    public function delete(array $condition): void
    {
        $this->repository->delete($condition);
    }

    public function getTagUuidsByArticleUuid(string $articleUuid): ?Collection
    {
        return $this->repository->all([
            'article_uuid' => $articleUuid,
        ])?->map(function ($row) {
            return $row->toArray();
        })?->pluck('tag_uuid');
    }

    public function getArticleUuidsByTagUuid(string $tagUuid): ?Collection
    {
        return $this->repository->all([
            'tag_uuid' => $tagUuid,
        ])?->map(function ($row) {
            return $row->toArray();
        })?->pluck('article_uuid');
    }
}
