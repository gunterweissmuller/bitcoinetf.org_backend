<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Kyc;

use App\Dto\Models\Kyc\ScreenDto;
use App\Repositories\Kyc\Screen\ScreenRepositoryInterface;
use Illuminate\Support\Collection;

final class ScreenService
{
    public function __construct(
        private readonly ScreenRepositoryInterface $repository,
    ) {
    }

    public function create(ScreenDto $dto): ScreenDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?ScreenDto
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
