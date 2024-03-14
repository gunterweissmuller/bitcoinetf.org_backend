<?php

declare(strict_types=1);

namespace App\Repositories\Users\Wallet;

use App\Dto\Models\Users\WalletDto;
use App\Models\Users\Wallet;

final class PgSqlWalletRepository implements WalletRepositoryInterface
{
    public function __construct(
        private readonly Wallet $model,
    ) {
    }

    public function create(WalletDto $dto): WalletDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return WalletDto::fromArray($model->toArray());
    }

    public function get(array $filters): ?WalletDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? WalletDto::fromArray($model->toArray()) : null;
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
