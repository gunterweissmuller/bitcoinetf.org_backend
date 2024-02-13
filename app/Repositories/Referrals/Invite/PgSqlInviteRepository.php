<?php

declare(strict_types=1);

namespace App\Repositories\Referrals\Invite;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Referrals\InviteDto;
use App\Models\Referrals\Invite;
use Illuminate\Support\Collection;

final class PgSqlInviteRepository implements InviteRepositoryInterface
{
    public function __construct(
        private readonly Invite $model,
    ) {
    }

    public function create(InviteDto $dto): InviteDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return InviteDto::fromArray($model->toArray());
    }

    public function get(array $filters): ?InviteDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? InviteDto::fromArray($model->toArray()) : null;
    }

    public function update(array $condition, array $data): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->update($data);
    }

    public function all(array $filters): ?Collection
    {
        $rows = $this->model
            ->newQuery()
            ->where($filters)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();

        return $rows ? Collection::make($rows)->map(function (array $row) {
            return InviteDto::fromArray($row);
        }) : null;
    }

    public function delete(array $condition): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->delete();
    }

    public function allByFilters(PaginationFilterDto $dto): Collection
    {
        return $this->model
            ->newQuery()
            ->where($dto->getFilters() ?? [])
            ->groupBy(['created_at'])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
