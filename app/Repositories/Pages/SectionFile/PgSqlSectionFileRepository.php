<?php

declare(strict_types=1);

namespace App\Repositories\Pages\SectionFile;

use Illuminate\Support\Collection;
use App\Models\Pages\SectionFile;
use App\Dto\Models\Pages\SectionFileDto;

final class PgSqlSectionFileRepository implements SectionFileRepositoryInterface
{
    private SectionFile $model;

    public function __construct(SectionFile $model)
    {
        $this->model = $model;
    }

    public function create(SectionFileDto $dto): void
    {
        $this->model
            ->newQuery()
            ->insert($dto->toArray());
    }

    public function update(array $condition, array $data): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->update($data);
    }

    public function get(array $filters): ?SectionFileDto
    {
        $object = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $object ? SectionFileDto::fromArray($object->toArray()) : null;
    }

    public function list(array $filters): ?Collection
    {
        $rows = $this->model
            ->newQuery()
            ->where($filters)
            ->get()
            ->toArray();

        return $rows ? Collection::make($rows)->map(function (array $row) {
            return SectionFileDto::fromArray($row);
        }) : null;
    }

    public function delete(array $filters): void
    {
        $this->model
            ->newQuery()
            ->where($filters)
            ->delete();
    }
}
