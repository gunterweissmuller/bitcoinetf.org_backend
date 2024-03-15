<?php

declare(strict_types=1);

namespace App\Repositories\Users\Profile;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Users\ProfileDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ProfileRepositoryInterface
{
    public function create(ProfileDto $dto): ProfileDto;

    public function get(array $filters): ?ProfileDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator;
}
