<?php

declare(strict_types=1);

namespace App\Repositories\News\Article;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\News\ArticleDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ArticleRepositoryInterface
{
    public function create(ArticleDto $dto): ArticleDto;

    public function get(array $filters): ?ArticleDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;

    public function allByFilters(PaginationFilterDto $dto, callable $callback = null): LengthAwarePaginator;
}
