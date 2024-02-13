<?php

declare(strict_types=1);

namespace App\Repositories\Billing\Replenishment;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Billing\ReplenishmentDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ReplenishmentRepositoryInterface
{
    public function create(ReplenishmentDto $dto): ReplenishmentDto;

    public function get(array $filters, callable $callback = null): ?ReplenishmentDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator;
}
