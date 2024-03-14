<?php

declare(strict_types=1);

namespace App\Services\Api\V1\News;

use App\Dto\Models\News\ArticleFileDto;
use App\Repositories\News\ArticleFile\ArticleFileRepositoryInterface;
use Illuminate\Support\Collection;

final class ArticleFileService
{
    public function __construct(
        private readonly ArticleFileRepositoryInterface $repository,
    ) {
    }

    public function create(ArticleFileDto $dto): ArticleFileDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?ArticleFileDto
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
}
