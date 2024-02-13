<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Pages;

use App\Dto\Models\Pages\PageDto;
use Illuminate\Support\Collection;
use App\Dto\Models\Pages\PagePaginationFilterDto;
use App\Repositories\Pages\Page\PageRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class PageService
{
    private PageRepositoryInterface $repository;

    public function __construct(PageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(PageDto $dto): PageDto
    {
        return $this->repository->create($dto);
    }

    public function update(array $condition, array $data): void
    {
        $this->repository->update(array_filter($condition), $data);
    }

    public function get(array $filters): ?PageDto
    {
        return $this->repository->get(array_filter($filters));
    }

    public function list(array $filters): ?Collection
    {
        return $this->repository->list(array_filter($filters));
    }

    public function delete(array $filters): void
    {
        $this->repository->delete(array_filter($filters));
    }

    public function allByFilters(PagePaginationFilterDto $dto): LengthAwarePaginator
    {
        $dto->setPage($dto->getPage() ?? config('app.pagination.page'));
        $dto->setPerPage($dto->getPerPage() ?? config('app.pagination.per_page'));

        return $this->repository->allByFilters($dto);
    }
}
