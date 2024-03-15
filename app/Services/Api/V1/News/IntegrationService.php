<?php

declare(strict_types=1);

namespace App\Services\Api\V1\News;

use Illuminate\Support\Collection;
use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\News\IntegrationDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\News\Integration\IntegrationRepositoryInterface;

final class IntegrationService
{
    public function __construct(
        private readonly IntegrationRepositoryInterface $repository,
    )
    {
    }

    public function create(IntegrationDto $dto): IntegrationDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?IntegrationDto
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
