<?php

declare(strict_types=1);

namespace App\Repositories\News\Section;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\News\SectionDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface SectionRepositoryInterface
{
    public function create(SectionDto $dto): SectionDto;

    public function get(array $filters): ?SectionDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator;
}
