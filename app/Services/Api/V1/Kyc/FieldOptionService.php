<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Kyc;

use App\Dto\Models\Kyc\FieldOptionDto;
use App\Repositories\Kyc\FieldOption\FieldOptionRepositoryInterface;
use Illuminate\Support\Collection;

final class FieldOptionService
{
    public function __construct(
        private readonly FieldOptionRepositoryInterface $repository,
    ) {
    }

    public function create(FieldOptionDto $dto): FieldOptionDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?FieldOptionDto
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
