<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Kyc;

use App\Dto\Models\Kyc\FormDto;
use App\Repositories\Kyc\Form\FormRepositoryInterface;
use Illuminate\Support\Collection;

final class FormService
{
    public function __construct(
        private readonly FormRepositoryInterface $repository,
    ) {
    }

    public function create(FormDto $dto): FormDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?FormDto
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
