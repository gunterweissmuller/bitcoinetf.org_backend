<?php

declare(strict_types=1);

namespace App\Repositories\Pages\Section;

use Illuminate\Support\Collection;
use App\Dto\Models\Pages\SectionDto;
use App\Dto\Core\PaginationFilterDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SectionRepositoryInterface
{
    public function create(SectionDto $dto): SectionDto;

    public function update(array $condition, array $data): void;

    public function get(array $filters): ?SectionDto;

    public function list(array $filters, callable $callback = null): ?Collection;

    public function delete(array $filters): void;

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator;
}
