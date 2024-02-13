<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Kyc;

use App\Dto\Models\Kyc\FieldDto;
use App\Repositories\Kyc\Field\FieldRepositoryInterface;
use Illuminate\Support\Collection;

final class FieldService
{
    public function __construct(
        private readonly FieldRepositoryInterface $repository,
    ) {
    }

    public function create(FieldDto $dto): FieldDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?FieldDto
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
