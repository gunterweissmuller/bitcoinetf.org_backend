<?php

declare(strict_types=1);

namespace App\Repositories\Pages\SectionTemplateFile;

use Illuminate\Support\Collection;
use App\Models\Pages\SectionTemplateFile;
use App\Dto\Models\Pages\SectionTemplateFileDto;

final class PgSqlSectionTemplateFileRepository implements SectionTemplateFileRepositoryInterface
{
    private SectionTemplateFile $model;

    public function __construct(SectionTemplateFile $model)
    {
        $this->model = $model;
    }

    public function create(SectionTemplateFileDto $dto): void
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

    public function get(array $filters): ?SectionTemplateFileDto
    {
        $object = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $object ? SectionTemplateFileDto::fromArray($object->toArray()) : null;
    }

    public function list(array $filters): ?Collection
    {
        $rows = $this->model
            ->newQuery()
            ->where($filters)
            ->get()
            ->toArray();

        return $rows ? Collection::make($rows)->map(function (array $row) {
            return SectionTemplateFileDto::fromArray($row);
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
