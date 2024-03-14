<?php

declare(strict_types=1);

namespace App\Services\Api\V1\News;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\News\SectionDto;
use App\Repositories\News\Section\SectionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class SectionService
{
    public function __construct(
        private readonly SectionRepositoryInterface $repository,
    ) {
    }

    public function create(SectionDto $dto): SectionDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?SectionDto
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

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator
    {
        $dto->setPage($dto->getPage() ?? config('app.pagination.page'));
        $dto->setPerPage($dto->getPerPage() ?? config('app.pagination.per_page'));

        return $this->repository->allByFilters($dto);
    }
}
