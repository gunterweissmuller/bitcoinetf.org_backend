<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Billing;

use Illuminate\Support\Collection;
use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Billing\CreditCardRequestDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Billing\CreditCardRequest\CreditCardRequestRepositoryInterface;

final class CreditCardRequestService
{
    public function __construct(private readonly CreditCardRequestRepositoryInterface $repository) {}

    public function create(CreditCardRequestDto $dto): CreditCardRequestDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?CreditCardRequestDto
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

    public function total(): int
    {
        return $this->repository->total();
    }

    public function number(string $createdAt): int
    {
        return $this->repository->number($createdAt);
    }
}
