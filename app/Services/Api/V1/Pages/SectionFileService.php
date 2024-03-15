<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Pages;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Dto\Models\Pages\SectionFileDto;
use App\Repositories\Pages\SectionFile\SectionFileRepositoryInterface;

final class SectionFileService
{
    private SectionFileRepositoryInterface $repository;

    public function __construct(SectionFileRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(SectionFileDto $dto): void
    {
        $dto->setCreatedAt(Carbon::now()->format('Y-m-d H:i:s'));
        $this->repository->create($dto);
    }

    public function update(array $condition, array $data): void
    {
        $this->repository->update(array_filter($condition), $data);
    }

    public function get(array $filters): ?SectionFileDto
    {
        return $this->repository->get(array_filter($filters));
    }

    public function list(array $filters): ?Collection
    {
        return $this->repository->list(array_filter($filters));
    }

    public function delete(array $filters): void
    {
        $this->repository->delete(array_filter($filters));
    }
}
