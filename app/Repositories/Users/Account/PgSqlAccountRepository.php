<?php

declare(strict_types=1);

namespace App\Repositories\Users\Account;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Users\AccountDto;
use App\Models\Users\Account;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class PgSqlAccountRepository implements AccountRepositoryInterface
{
    public function __construct(
        private readonly Account $model,
    ) {
    }

    public function create(AccountDto $dto): AccountDto
    {
        $model = $this->model
            ->newQuery()
            ->create(
                array_filter($dto->toArray(), function ($value) {
                    return ($value !== null);
                }),
            );

        return AccountDto::fromArray($model->toArray());
    }

    public function get(array $filters): ?AccountDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? AccountDto::fromArray($model->toArray()) : null;
    }

    public function update(array $condition, array $data): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->update($data);
    }

    public function all(array $filters): ?Collection
    {
        $rows = $this->model
            ->newQuery()
            ->where($filters)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();

        return $rows ? Collection::make($rows)->map(function (array $row) {
            return AccountDto::fromArray($row);
        }) : null;
    }

    public function delete(array $condition): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->delete();
    }

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator
    {
        return $this->model
            ->newQuery()
            ->where($dto->getFilters() ?? [])
            ->orderBy($dto->getOrderColumn() ?? 'created_at', $dto->getOrderBy() ?? 'desc')
            ->paginate($dto->getPerPage(), ['*'], 'page', $dto->getPage());
    }

    public function allByFiltersWithChunk(array $filters, int $count, callable $callback): void
    {
        $this->model
            ->newQuery()
            ->where($filters)
            ->orderBy('created_at', 'desc')
            ->chunk($count, $callback);
    }

    public function countNewUsers(string $from, string $to): int
    {
        return $this->model
            ->newQuery()
            ->where('created_at', '>=', $from)
            ->where('created_at', '<=', $to)
            ->count();
    }

    public function allUserInfoByFiltersWithChunk(array $filters, int $count, callable $callback): void
    {
        $this->model
            ->newQuery()
            ->select(['users.accounts.uuid', 'users.emails.email', 'users.profiles.full_name'])
            ->leftJoin('users.emails', 'users.emails.account_uuid', '=', 'users.accounts.uuid')
            ->leftJoin('users.profiles', 'users.profiles.account_uuid', '=', 'users.accounts.uuid')
            ->where($filters)
            ->orderBy('users.accounts.created_at', 'desc')
            ->chunk($count, $callback);
    }
}
