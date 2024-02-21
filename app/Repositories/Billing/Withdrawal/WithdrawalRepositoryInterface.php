<?php

declare(strict_types=1);

namespace App\Repositories\Billing\Withdrawal;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Billing\WithdrawalDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface WithdrawalRepositoryInterface
{
    public function create(WithdrawalDto $dto): WithdrawalDto;

    public function get(array $filters): ?WithdrawalDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator;
}
