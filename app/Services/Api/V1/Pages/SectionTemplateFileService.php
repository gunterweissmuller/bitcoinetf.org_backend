<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Pages;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Dto\Models\Pages\SectionTemplateFileDto;
use App\Repositories\Pages\SectionTemplateFile\SectionTemplateFileRepositoryInterface;

final class SectionTemplateFileService
{
    private SectionTemplateFileRepositoryInterface $repository;

    public function __construct(SectionTemplateFileRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(SectionTemplateFileDto $dto): void
    {
        $dto->setCreatedAt(Carbon::now()->format('Y-m-d H:i:s'));
        $this->repository->create($dto);
    }

    public function update(array $condition, array $data): void
    {
        $this->repository->update(array_filter($condition), $data);
    }

    public function get(array $filters): ?SectionTemplateFileDto
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
