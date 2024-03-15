<?php

declare(strict_types=1);

namespace App\Repositories\Pap\Tracking;

use App\Dto\Models\Pap\TrackingDto;
use App\Models\Pap\Tracking;

final class PgSqlTrackingRepository implements TrackingRepositoryInterface
{
    public function __construct(
        private readonly Tracking $model,
    ) {
    }

    public function create(TrackingDto $dto): TrackingDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return TrackingDto::fromArray($model->toArray());
    }

    public function get(array $filters): ?TrackingDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? TrackingDto::fromArray($model->toArray()) : null;
    }

    public function update(array $condition, array $data): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->update($data);
    }

    public function delete(array $condition): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->delete();
    }
}
