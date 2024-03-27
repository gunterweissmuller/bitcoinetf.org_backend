<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Users;

use App\Dto\Models\Users\FacebookDto;
use App\Repositories\Users\Facebook\FacebookRepositoryInterface;

final class FacebookService
{
    public function __construct(
        private readonly FacebookRepositoryInterface $repository,
    ) {
    }

    public function create(FacebookDto $dto): FacebookDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?FacebookDto
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
