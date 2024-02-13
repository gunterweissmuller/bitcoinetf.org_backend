<?php

declare(strict_types=1);

namespace App\Repositories\News\Integration;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\News\IntegrationDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface IntegrationRepositoryInterface
{
    public function create(IntegrationDto $dto): IntegrationDto;

    public function get(array $filters): ?IntegrationDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator;
}
