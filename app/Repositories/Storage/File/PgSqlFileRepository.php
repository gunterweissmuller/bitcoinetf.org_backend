<?php

declare(strict_types=1);

namespace App\Repositories\Storage\File;

use App\Dto\Models\Storage\FileDto;
use App\Models\Storage\File;
use Illuminate\Support\Collection;

final class PgSqlFileRepository implements FileRepositoryInterface
{
    private File $model;

    public function __construct(File $model)
    {
        $this->model = $model;
    }

    public function create(FileDto $dto): FileDto
    {
        $object = $this->model
            ->newQuery()
            ->create($dto->toArray());

        return FileDto::fromArray($object->toArray());
    }

    public function update(array $condition, array $data): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->update($data);
    }

    public function get(array $filters): ?FileDto
    {
        $object = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $object ? FileDto::fromArray($object->toArray()) : null;
    }

    public function list(array $filters, callable $callback = null): ?Collection
    {
        $rows = $this->model
            ->newQuery()
            ->where($filters)
            ->where($callback)
            ->get()
            ->toArray();

        return $rows ? Collection::make($rows)->map(function (array $row) {
            return FileDto::fromArray($row);
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
}
