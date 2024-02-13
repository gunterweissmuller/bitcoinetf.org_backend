<?php

declare(strict_types=1);

namespace App\Repositories\Users\Account;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Users\AccountDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface AccountRepositoryInterface
{
    public function create(AccountDto $dto): AccountDto;

    public function get(array $filters): ?AccountDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator;

    public function allByFiltersWithChunk(array $filters, int $count, callable $callback): void;

    public function countNewUsers(string $from, string $to): int;
}
