<?php

declare(strict_types=1);

namespace App\Repositories\Referrals\Code;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Referrals\CodeDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface CodeRepositoryInterface
{
    public function create(CodeDto $dto): CodeDto;

    public function get(array $filters): ?CodeDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator;
}
