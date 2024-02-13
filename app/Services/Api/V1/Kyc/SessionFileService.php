<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Kyc;

use App\Dto\Models\Kyc\SessionFileDTO;
use App\Repositories\Kyc\SessionFile\SessionFileRepositoryInterface;
use Illuminate\Support\Collection;

final class SessionFileService
{
    public function __construct(
        private readonly SessionFileRepositoryInterface $repository,
    ) {
    }

    public function create(SessionFileDTO $dto): SessionFileDTO
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?SessionFileDTO
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
