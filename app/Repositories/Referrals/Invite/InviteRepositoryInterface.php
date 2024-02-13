<?php

declare(strict_types=1);

namespace App\Repositories\Referrals\Invite;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Referrals\InviteDto;
use Illuminate\Support\Collection;

interface InviteRepositoryInterface
{
    public function create(InviteDto $dto): InviteDto;

    public function get(array $filters): ?InviteDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;

    public function allByFilters(PaginationFilterDto $dto): Collection;
}
