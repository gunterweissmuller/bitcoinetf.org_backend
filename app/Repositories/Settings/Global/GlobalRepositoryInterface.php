<?php

declare(strict_types=1);

namespace App\Repositories\Settings\Global;

use Illuminate\Support\Collection;
use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Settings\GlobalDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface GlobalRepositoryInterface
{
    public function create(GlobalDto $dto): GlobalDto;

    public function get(array $filters): ?GlobalDto;

    public function update(array $condition, array $data): void;

    public function list(array $filters): ?Collection;

    public function delete(array $condition): void;

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator;
}
