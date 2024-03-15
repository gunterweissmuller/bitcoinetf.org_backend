<?php

declare(strict_types=1);

namespace App\Repositories\Pages\Language;

use Illuminate\Support\Collection;
use App\Dto\Models\Pages\LanguageDto;
use App\Dto\Core\PaginationFilterDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface LanguageRepositoryInterface
{
    public function create(LanguageDto $dto): LanguageDto;

    public function update(array $condition, array $data): void;

    public function get(array $filters): ?LanguageDto;

    public function list(array $filters): ?Collection;

    public function delete(array $filters): void;

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator;
}
