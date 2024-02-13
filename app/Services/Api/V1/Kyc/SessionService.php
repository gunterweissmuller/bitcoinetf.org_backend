<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Kyc;

use App\Dto\Models\Kyc\SessionDto;
use App\Repositories\Kyc\Session\SessionRepositoryInterface;
use Illuminate\Support\Collection;

final class SessionService
{
    public function __construct(
        private readonly SessionRepositoryInterface $repository,
    ) {
    }

    public function create(SessionDto $dto): SessionDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?SessionDto
    {
        return $this->repository->get($filters);
    }

    public function update(array $condition, array $data): void
    {
        $this->repository->update($condition, $data);
    }

    public function all(array $filters): ?Collection
    {
        return $this->repository->all($filters);
    }

    public function delete(array $condition): void
    {
        $this->repository->delete($condition);
    }
}
