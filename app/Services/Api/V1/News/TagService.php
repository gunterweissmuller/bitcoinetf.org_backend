<?php

declare(strict_types=1);

namespace App\Services\Api\V1\News;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\News\TagDto;
use App\Repositories\News\Tag\TagRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class TagService
{
    public function __construct(
        private readonly TagRepositoryInterface $repository,
    ) {
    }

    public function create(TagDto $dto): TagDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?TagDto
    {
        return $this->repository->get($filters);
    }

    public function update(array $condition, array $data): void
    {
        $this->repository->update($condition, $data);
    }

    public function all(array $filters, ?callable $callback = null): ?Collection
    {
        return $this->repository->all($filters, $callback);
    }

    public function delete(array $condition): void
    {
        $this->repository->delete($condition);
    }

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator
    {
        $dto->setPage($dto->getPage() ?? config('app.pagination.page'));
        $dto->setPerPage($dto->getPerPage() ?? config('app.pagination.per_page'));

        return $this->repository->allByFilters($dto);
    }
}
