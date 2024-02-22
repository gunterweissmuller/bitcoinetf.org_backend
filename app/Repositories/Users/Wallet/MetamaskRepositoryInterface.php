<?php

declare(strict_types=1);

namespace App\Repositories\Users\Wallet;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Users\WalletDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface MetamaskRepositoryInterface
{
    public function create(WalletDto $dto): WalletDto;

    public function get(array $filters): ?WalletDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator;
}
