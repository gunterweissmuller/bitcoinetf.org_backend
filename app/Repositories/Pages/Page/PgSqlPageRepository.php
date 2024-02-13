<?php

declare(strict_types=1);

namespace App\Repositories\Pages\Page;

use App\Models\Pages\Page;
use App\Dto\Models\Pages\PageDto;
use Illuminate\Support\Collection;
use App\Dto\Models\Pages\PagePaginationFilterDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class PgSqlPageRepository implements PageRepositoryInterface
{
    private Page $model;

    public function __construct(Page $model)
    {
        $this->model = $model;
    }

    public function create(PageDto $dto): PageDto
    {
        $object = $this->model
            ->newQuery()
            ->create($dto->toArray());

        return PageDto::fromArray($object->toArray());
    }

    public function update(array $condition, array $data): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->update($data);
    }

    public function get(array $filters): ?PageDto
    {
        $object = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $object ? PageDto::fromArray($object->toArray()) : null;
    }

    public function list(array $filters): ?Collection
    {
        $rows = $this->model
            ->newQuery()
            ->where($filters)
            ->get()
            ->toArray();

        return $rows ? Collection::make($rows)->map(function (array $row) {
            return PageDto::fromArray($row);
        }) : null;
    }

    public function delete(array $filters): void
    {
        $this->model
            ->newQuery()
            ->where($filters)
            ->delete();
    }

    public function count(array $filters): int
    {
        return $this->model
            ->newQuery()
            ->where($filters)
            ->count();
    }

    public function allByFilters(PagePaginationFilterDto $dto): LengthAwarePaginator
    {
        $query = $this->model
            ->newQuery();

        if ($slug = $dto->getSlug()) {
            $query = $query->where('slug', '=', $slug);
        }

        return $query->orderByDesc('created_at')
            ->paginate($dto->getPerPage(), ['*'], 'page', $dto->getPage());
    }
}
