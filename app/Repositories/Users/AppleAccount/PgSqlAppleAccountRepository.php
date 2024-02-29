<?php

declare(strict_types=1);

namespace App\Repositories\Users\AppleAccount;

use App\Dto\Models\Users\AppleAccountDto;
use App\Models\Users\AppleAccount;

final class PgSqlAppleAccountRepository implements AppleAccountRepositoryInterface
{
    public function __construct(
        private readonly AppleAccount $model,
    ) {
    }

    /**
     * @param AppleAccountDto $dto
     * @return AppleAccountDto
     */
    public function create(AppleAccountDto $dto): AppleAccountDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return AppleAccountDto::fromArray($model->toArray());
    }

    /**
     * @param array $filters
     * @return AppleAccountDto|null
     */
    public function get(array $filters): ?AppleAccountDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? AppleAccountDto::fromArray($model->toArray()) : null;
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
