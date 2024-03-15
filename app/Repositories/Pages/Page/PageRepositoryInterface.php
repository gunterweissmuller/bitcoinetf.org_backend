<?php

declare(strict_types=1);

namespace App\Repositories\Pages\Page;

use Illuminate\Support\Collection;
use App\Dto\Models\Pages\PageDto;
use App\Dto\Models\Pages\PagePaginationFilterDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PageRepositoryInterface
{
    public function create(PageDto $dto): PageDto;

    public function update(array $condition, array $data): void;

    public function get(array $filters): ?PageDto;

    public function list(array $filters): ?Collection;

    public function delete(array $filters): void;

    public function allByFilters(PagePaginationFilterDto $dto): LengthAwarePaginator;
}
