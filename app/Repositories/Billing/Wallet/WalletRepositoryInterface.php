<?php

declare(strict_types=1);

namespace App\Repositories\Billing\Wallet;

use Illuminate\Support\Collection;
use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Billing\WalletDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface WalletRepositoryInterface
{
    public function create(WalletDto $dto): WalletDto;

    public function get(array $filters): ?WalletDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator;

    public function allByFiltersWithChunk(array $filters, int $count, callable $callback): void;
}
