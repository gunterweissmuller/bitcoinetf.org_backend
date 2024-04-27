<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Users;

use App\Dto\Models\Users\MetadataDto;
use App\Repositories\Users\Metadata\MetadataRepositoryInterface;

final class MetadataService
{
    public function __construct(
        private readonly MetadataRepositoryInterface $repository,
    ) {
    }

    public function create(MetadataDto $dto): MetadataDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?MetadataDto
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
