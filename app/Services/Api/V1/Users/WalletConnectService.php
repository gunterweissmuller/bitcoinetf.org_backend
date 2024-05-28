<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Users;

use App\Dto\Models\Users\WalletConnectDto;
use App\Repositories\Users\WalletConnect\WalletConnectRepositoryInterface;

final class WalletConnectService
{
    /**
     * @param WalletConnectRepositoryInterface $repository
     */
    public function __construct(
        private readonly WalletConnectRepositoryInterface $repository,
    ) {
    }

    /**
     * @param WalletConnectDto $dto
     * @return WalletConnectDto
     */
    public function create(WalletConnectDto $dto): WalletConnectDto
    {
        return $this->repository->create($dto);
    }

    /**
     * @param array $filters
     * @return WalletConnectDto|null
     */
    public function get(array $filters): ?WalletConnectDto
    {
        return $this->repository->get($filters);
    }

    /**
     * @param array $condition
     * @param array $data
     * @return void
     */
    public function update(array $condition, array $data): void
    {
        $this->repository->update($condition, $data);
    }

    /**
     * @param array $condition
     * @return void
     */
    public function delete(array $condition): void
    {
        $this->repository->delete($condition);
    }
}
