<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Pap;

use App\Dto\Models\Pap\TrackingDto;
use App\Repositories\Pap\Tracking\TrackingRepositoryInterface;

final class TrackingService
{
    public function __construct(
        private readonly TrackingRepositoryInterface $repository,
    ) {
    }

    public function create(TrackingDto $dto): TrackingDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?TrackingDto
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
