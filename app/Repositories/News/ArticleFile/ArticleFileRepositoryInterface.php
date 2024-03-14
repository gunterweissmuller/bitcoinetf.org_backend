<?php

declare(strict_types=1);

namespace App\Repositories\News\ArticleFile;

use App\Dto\Models\News\ArticleFileDto;
use Illuminate\Support\Collection;

interface ArticleFileRepositoryInterface
{
    public function create(ArticleFileDto $dto): ArticleFileDto;

    public function get(array $filters): ?ArticleFileDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;
}
