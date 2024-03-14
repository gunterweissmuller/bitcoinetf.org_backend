<?php

declare(strict_types=1);

namespace App\Repositories\Auth\RefreshToken;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Auth\RefreshTokenDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface RefreshTokenRepositoryInterface
{
    public function create(RefreshTokenDto $dto): RefreshTokenDto;

    public function get(array $filters): ?RefreshTokenDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator;
}
