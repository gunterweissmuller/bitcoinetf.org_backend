<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Users;

use App\Dto\Models\Users\AppleAccountDto;
use App\Repositories\Users\AppleAccount\AppleAccountRepositoryInterface;

final class AppleAccountService
{
    public function __construct(
        private readonly AppleAccountRepositoryInterface $repository,
    ) {
    }

    public function create(AppleAccountDto $dto): AppleAccountDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?AppleAccountDto
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
