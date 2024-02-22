<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Users;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Users\WalletDto;
use App\Repositories\Users\Wallet\MetamaskRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class MetamaskService
{
    public function __construct(
        private readonly MetamaskRepositoryInterface $repository,
    ) {
    }

    public function create(WalletDto $dto): WalletDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?WalletDto
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
