<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Users;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Users\AccountDto;
use App\Repositories\Users\Account\AccountRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

final class AccountService
{
    public function __construct(private readonly AccountRepositoryInterface $repository)
    {
    }

    public function create(AccountDto $dto): AccountDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?AccountDto
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

    public function getPersonalBonusValue(string $accountUuid): ?float
    {
        return (float) $this->repository->get([
            'uuid' => $accountUuid,
        ])->getPersonalBonus();
    }

    public function isAccountHalfYear(string $accountUuid): bool
    {
        $account = $this->repository->get(['uuid' => $accountUuid]);
        $inMonths = Carbon::now()->addDay()->diffInMonths(Carbon::parse($account->getCreatedAt()));
        return $inMonths <= 6;
    }

    public function countNewUsers(string $from, string $to): int
    {
        return $this->repository->countNewUsers($from, $to);
    }

    public function allUserInfoByFiltersWithChunk(array $filters, int $count, callable $callback): void
    {
        $this->repository->allUserInfoByFiltersWithChunk($filters, $count, $callback);
    }
}
