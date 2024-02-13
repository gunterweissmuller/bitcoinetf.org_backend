<?php

declare(strict_types=1);

namespace App\Repositories\Settings\Global;

use Illuminate\Support\Collection;
use App\Models\Settings\GlobalModel;
use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Settings\GlobalDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class PgSqlGlobalRepository implements GlobalRepositoryInterface
{
    private GlobalModel $model;

    public function __construct(GlobalModel $model)
    {
        $this->model = $model;
    }

    public function create(GlobalDto $dto): GlobalDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return GlobalDto::fromArray($model->toArray());
    }

    public function get(array $filters): ?GlobalDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? GlobalDto::fromArray($model->toArray()) : null;
    }

    public function update(array $condition, array $data): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->update($data);
    }

    public function list(array $filters): ?Collection
    {
        $rows = $this->model
            ->newQuery()
            ->where($filters)
            ->get()
            ->toArray();

        return $rows ? Collection::make($rows)->map(function (array $row) {
            return GlobalDto::fromArray($row);
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
            ->orderByDesc('created_at')
            ->paginate($dto->getPerPage(), ['*'], 'page', $dto->getPage());
    }
}
