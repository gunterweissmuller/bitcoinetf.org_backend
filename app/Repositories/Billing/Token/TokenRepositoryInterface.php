<?php

declare(strict_types=1);

namespace App\Repositories\Billing\Token;

use Illuminate\Support\Collection;
use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Billing\TokenDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TokenRepositoryInterface
{
    public function create(TokenDto $dto): TokenDto;

    public function get(array $filters): ?TokenDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator;
}
