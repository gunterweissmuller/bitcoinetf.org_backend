<?php

declare(strict_types=1);

namespace App\Repositories\Pages\Language;

use App\Models\Pages\Language;
use Illuminate\Support\Collection;
use App\Dto\Models\Pages\LanguageDto;
use App\Dto\Core\PaginationFilterDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class PgSqlLanguageRepository implements LanguageRepositoryInterface
{
    private Language $model;

    public function __construct(Language $model)
    {
        $this->model = $model;
    }

    public function create(LanguageDto $dto): LanguageDto
    {
        $object = $this->model
            ->newQuery()
            ->create($dto->toArray());

        return LanguageDto::fromArray($object->toArray());
    }

    public function update(array $condition, array $data): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->update($data);
    }

    public function get(array $filters): ?LanguageDto
    {
        $object = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $object ? LanguageDto::fromArray($object->toArray()) : null;
    }

    public function list(array $filters): ?Collection
    {
        $rows = $this->model
            ->newQuery()
            ->where($filters)
            ->get()
            ->toArray();

        return $rows ? Collection::make($rows)->map(function (array $row) {
            return LanguageDto::fromArray($row);
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

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator
    {
        return $this->model
            ->newQuery()
            ->orderByDesc('created_at')
            ->paginate($dto->getPerPage(), ['*'], 'page', $dto->getPage());
    }
}
