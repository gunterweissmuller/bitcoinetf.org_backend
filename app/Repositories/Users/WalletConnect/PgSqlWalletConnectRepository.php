<?php

declare(strict_types=1);

namespace App\Repositories\Users\WalletConnect;

use App\Dto\Models\Users\WalletConnectDto;
use App\Models\Users\WalletConnect;

final class PgSqlWalletConnectRepository implements WalletConnectRepositoryInterface
{
    /**
     * @param WalletConnect $model
     */
    public function __construct(
        private readonly WalletConnect $model,
    )
    {
    }

    /**
     * @param WalletConnectDto $dto
     * @return WalletConnectDto
     */
    public function create(WalletConnectDto $dto): WalletConnectDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return WalletConnectDto::fromArray($model->toArray());
    }

    /**
     * @param array $filters
     * @return WalletConnectDto|null
     */
    public function get(array $filters): ?WalletConnectDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? WalletConnectDto::fromArray($model->toArray()) : null;
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
