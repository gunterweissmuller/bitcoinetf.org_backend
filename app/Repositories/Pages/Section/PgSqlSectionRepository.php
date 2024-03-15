<?php

declare(strict_types=1);

namespace App\Repositories\Pages\Section;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Pages\SectionDto;
use App\Models\Pages\Section;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class PgSqlSectionRepository implements SectionRepositoryInterface
{
    private Section $model;

    public function __construct(Section $model)
    {
        $this->model = $model;
    }

    public function create(SectionDto $dto): SectionDto
    {
        $object = $this->model
            ->newQuery()
            ->create($dto->toArray());

        return SectionDto::fromArray($object->toArray());
    }

    public function update(array $condition, array $data): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->update($data);
    }

    public function get(array $filters): ?SectionDto
    {
        $object = $this->model
            ->newQuery()
            ->where($filters)
            ->with('files', (function ($query) {
                return $query->select([
                    'storage.files.uuid',
                    'storage.files.type',
                    'storage.files.extension',
                    'storage.files.status',
                    'storage.files.path',
                    'storage.files.real_path',
                    'storage.files.created_at',
                    'storage.files.updated_at'
                ]);
            }))
            ->first();

        return $object ? SectionDto::fromArray($object->toArray()) : null;
    }

    public function list(array $filters, callable $callback = null): ?Collection
    {
        $rows = $this->model
            ->newQuery()
            ->where($filters)
            ->where($callback)
            ->orderBy('number')
            ->with('files', (function ($query) {
                return $query->select([
                    'storage.files.uuid',
                    'storage.files.type',
                    'storage.files.extension',
                    'storage.files.status',
                    'storage.files.path',
                    'storage.files.real_path',
                    'storage.files.created_at',
                    'storage.files.updated_at'
                ]);
            }))
            ->get()
            ->toArray();

        return $rows ? Collection::make($rows)->map(function (array $row) {
            return SectionDto::fromArray($row);
        }) : null;
    }

    public function delete(array $filters): void
    {
        $this->model
            ->newQuery()
            ->where($filters)
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
