<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Users;

use App\Dto\Models\Users\WalletDto;
use App\Repositories\Users\Wallet\WalletRepositoryInterface;

final class WalletService
{
    public function __construct(
        private readonly WalletRepositoryInterface $repository,
    ) {
    }

    public function create(WalletDto $dto): WalletDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?WalletDto
    {
        return $this->repository->get($filters);
    }

    public function update(array $condition, array $data): void
    {
        $this->repository->update($condition, $data);
    }

    public function delete(array $condition): void
    {
        $this->repository->delete($condition);
    }
}
