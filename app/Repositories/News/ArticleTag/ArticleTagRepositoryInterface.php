<?php

declare(strict_types=1);

namespace App\Repositories\News\ArticleTag;

use App\Dto\Models\News\ArticleTagDto;
use Illuminate\Support\Collection;

interface ArticleTagRepositoryInterface
{
    public function create(ArticleTagDto $dto): ArticleTagDto;

    public function get(array $filters): ?ArticleTagDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;
}
