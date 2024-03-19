<?php

declare(strict_types=1);

namespace App\Repositories\Users\Facebook;

use App\Dto\Models\Users\FacebookDto;
use App\Models\Users\Facebook;

final class PgSqlFacebookRepository implements FacebookRepositoryInterface
{
    public function __construct(
        private readonly Facebook $model,
    )
    {
    }

    public function create(FacebookDto $dto): FacebookDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return FacebookDto::fromArray($model->toArray());
    }

    public function get(array $filters): ?FacebookDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? FacebookDto::fromArray($model->toArray()) : null;
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
