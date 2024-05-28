<?php

declare(strict_types=1);

namespace App\Repositories\Billing\Sell;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Billing\SellDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface SellRepositoryInterface
{
    public function create(SellDto $dto): SellDto;

    public function get(array $filters): ?SellDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator;
}
