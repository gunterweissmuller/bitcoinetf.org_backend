<?php

declare(strict_types=1);

namespace App\Repositories\Users\Email;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Users\EmailDto;
use App\Models\Users\Email;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class PgSqlEmailRepository implements EmailRepositoryInterface
{
    public function __construct(
        private readonly Email $model,
    ) {
    }

    public function create(EmailDto $dto): EmailDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return EmailDto::fromArray($model->toArray());
    }

    public function get(array $filters): ?EmailDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? EmailDto::fromArray($model->toArray()) : null;
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
            return EmailDto::fromArray($row);
        }) : null;
    }

    public function delete(array $condition): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->delete();
    }

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator
    {
        return $this->model
            ->newQuery()
            ->orderBy('created_at', 'desc')
            ->paginate($dto->getPerPage(), ['*'], 'page', $dto->getPage());
    }
}
