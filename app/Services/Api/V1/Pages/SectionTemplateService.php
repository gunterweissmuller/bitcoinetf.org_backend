<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Pages;

use Illuminate\Support\Collection;
use App\Dto\Models\Pages\SectionTemplateDto;
use App\Repositories\Pages\SectionTemplate\SectionTemplateRepositoryInterface;

final class SectionTemplateService
{
    private SectionTemplateRepositoryInterface $repository;

    public function __construct(SectionTemplateRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(SectionTemplateDto $dto): SectionTemplateDto
    {
        return $this->repository->create($dto);
    }

    public function update(array $condition, array $data): void
    {
        $emptyData = array_filter($data);

        if ($data['data'] === []) {
            $emptyData['data'] = [];
        }

        $this->repository->update(array_filter($condition), $emptyData);
    }

    public function get(array $filters): ?SectionTemplateDto
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
