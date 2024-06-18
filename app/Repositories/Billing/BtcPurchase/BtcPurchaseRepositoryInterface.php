<?php

declare(strict_types=1);

namespace App\Repositories\Billing\BtcPurchase;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Billing\BtcPurchaseDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface BtcPurchaseRepositoryInterface
{
    public function create(BtcPurchaseDto $dto): BtcPurchaseDto;

    public function get(array $filters): ?BtcPurchaseDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator;

    public function allByFiltersWithChunk(array $filters, int $count, callable $callback): void;
}
