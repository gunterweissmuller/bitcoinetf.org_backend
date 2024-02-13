<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Kyc;

use App\Dto\Models\Kyc\SessionResultDto;
use App\Repositories\Kyc\SessionResult\SessionResultRepositoryInterface;
use Illuminate\Support\Collection;

final class SessionResultService
{
    public function __construct(
        private readonly SessionResultRepositoryInterface $repository,
    ) {
    }

    public function create(SessionResultDto $dto): SessionResultDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?SessionResultDto
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
