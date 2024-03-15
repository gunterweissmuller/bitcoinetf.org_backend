<?php

declare(strict_types=1);

namespace App\Repositories\Fund\Shareholder;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Fund\ShareholderDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ShareholderRepositoryInterface
{
    public function create(ShareholderDto $dto): ShareholderDto;

    public function get(array $filters): ?ShareholderDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator;

    public function allByFiltersWithChunk(array $filters, int $count, callable $callback): void;

    public function getTotalPayments(array $filters, callable $callback = null): float;

    public function getCount(array $filters): int;

    public function getTop(PaginationFilterDto $dto, array|string $select = '*'): LengthAwarePaginator;
}
