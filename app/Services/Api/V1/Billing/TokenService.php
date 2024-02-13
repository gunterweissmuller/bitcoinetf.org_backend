<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Billing;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Billing\TokenDto;
use App\Repositories\Billing\Token\TokenRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class TokenService
{
    public function __construct(
        private readonly TokenRepositoryInterface $repository,
    ) {
    }

    public function create(TokenDto $dto): TokenDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?TokenDto
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

    public function getBitcoinAmount(): ?float
    {
        return $this->repository->get(['symbol' => 'bitcoin'])?->getAmount() ?? 0;
    }
}
