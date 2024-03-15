<?php

declare(strict_types=1);

namespace App\Repositories\Users\Telegram;

use App\Dto\Models\Users\TelegramDto;
use App\Models\Users\Telegram;

final class PgSqlTelegramRepository implements TelegramRepositoryInterface
{
    public function __construct(
        private readonly Telegram $model,
    )
    {
    }

    public function create(TelegramDto $dto): TelegramDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return TelegramDto::fromArray($model->toArray());
    }

    public function get(array $filters): ?TelegramDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? TelegramDto::fromArray($model->toArray()) : null;
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
