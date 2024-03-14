<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Pages;

use Illuminate\Support\Collection;
use App\Dto\Models\Pages\SectionDto;
use App\Enums\Pages\Pages\StatusEnum;
use App\Dto\Core\PaginationFilterDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Pages\Section\SectionRepositoryInterface;

final class SectionService
{
    private SectionRepositoryInterface $repository;

    public function __construct(SectionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(SectionDto $dto): SectionDto
    {
        $dto->setStatus(StatusEnum::ACTIVE->value);

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

    public function get(array $filters): ?SectionDto
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

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator
    {
        $dto->setPage($dto->getPage() ?? config('app.pagination_default_page'));
        $dto->setPerPage($dto->getPerPage() ?? config('app.pagination_default_length'));

        return $this->repository->allByFilters($dto);
    }
}
