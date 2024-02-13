<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Fund;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Fund\ShareholderDto;
use App\Repositories\Fund\Shareholder\ShareholderRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class ShareholderService
{
    public function __construct(
        private readonly ShareholderRepositoryInterface $repository,
    ) {
    }

    public function create(ShareholderDto $dto): ShareholderDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?ShareholderDto
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

    public function allByFiltersWithChunk(array $filters, int $count, callable $callback): void
    {
        $this->repository->allByFiltersWithChunk($filters, $count, $callback);
    }

    public function getTotalPayments(array $filters, callable $callback = null): float
    {
        return $this->repository->getTotalPayments($filters, $callback);
    }

    public function getCount(array $filters): int
    {
        return $this->repository->getCount($filters);
    }

    public function getTop(PaginationFilterDto $dto, array|string $select = '*'): LengthAwarePaginator
    {
        $dto->setPage($dto->getPage() ?? config('app.pagination.page'));
        $dto->setPerPage($dto->getPerPage() ?? config('app.pagination.per_page'));

        return $this->repository->getTop($dto, $select);
    }
}
