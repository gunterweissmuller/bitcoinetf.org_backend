<?php

declare(strict_types=1);

namespace App\Repositories\Users\Metadata;

use App\Dto\Models\Users\MetadataDto;
use App\Models\Users\Metadata;

final class PgSqlMetadataRepository implements MetadataRepositoryInterface
{
    public function __construct(
        private readonly Metadata $model,
    )
    {
    }

    /**
     * @param MetadataDto $dto
     * @return MetadataDto
     */
    public function create(MetadataDto $dto): MetadataDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return MetadataDto::fromArray($model->toArray());
    }

    /**
     * @param array $filters
     * @return MetadataDto|null
     */
    public function get(array $filters): ?MetadataDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? MetadataDto::fromArray($model->toArray()) : null;
    }

    /**
     * @param array $condition
     * @param array $data
     * @return void
     */
    public function update(array $condition, array $data): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->update($data);
    }

    /**
     * @param array $condition
     * @return void
     */
    public function delete(array $condition): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->delete();
    }
}
