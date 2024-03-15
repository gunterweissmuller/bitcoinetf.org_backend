<?php

declare(strict_types=1);

namespace App\Repositories\News\Tag;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\News\TagDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface TagRepositoryInterface
{
    public function create(TagDto $dto): TagDto;

    public function get(array $filters): ?TagDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters, ?callable $callback): ?Collection;

    public function delete(array $condition): void;

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator;
}
