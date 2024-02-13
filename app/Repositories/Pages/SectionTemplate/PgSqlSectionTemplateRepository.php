<?php

declare(strict_types=1);

namespace App\Repositories\Pages\SectionTemplate;

use Illuminate\Support\Collection;
use App\Models\Pages\SectionTemplate;
use App\Dto\Models\Pages\SectionTemplateDto;

final class PgSqlSectionTemplateRepository implements SectionTemplateRepositoryInterface
{
    private SectionTemplate $model;

    public function __construct(SectionTemplate $model)
    {
        $this->model = $model;
    }

    public function create(SectionTemplateDto $dto): SectionTemplateDto
    {
        $object = $this->model
            ->newQuery()
            ->create($dto->toArray());

        return SectionTemplateDto::fromArray($object->toArray());
    }

    public function update(array $condition, array $data): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->update($data);
    }

    public function get(array $filters): ?SectionTemplateDto
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

        return $object ? SectionTemplateDto::fromArray($object->toArray()) : null;
    }

    public function list(array $filters): ?Collection
    {
        $rows = $this->model
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
            ->get()
            ->toArray();

        return $rows ? Collection::make($rows)->map(function (array $row) {
            return SectionTemplateDto::fromArray($row);
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
