<?php

declare(strict_types=1);

namespace App\Repositories\Statistic\DailyWallet;

use Illuminate\Support\Collection;
use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Statistic\DailyWalletDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface DailyWalletRepositoryInterface
{
    public function create(DailyWalletDto $dto): DailyWalletDto;

    public function get(array $filters): ?DailyWalletDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator;
}
