<?php

declare(strict_types=1);

namespace App\Repositories\Users\Email;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Users\EmailDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface EmailRepositoryInterface
{
    public function create(EmailDto $dto): EmailDto;

    public function get(array $filters): ?EmailDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator;
}
