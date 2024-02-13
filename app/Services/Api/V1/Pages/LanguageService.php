<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Pages;

use Illuminate\Support\Collection;
use App\Dto\Models\Pages\LanguageDto;
use App\Dto\Core\PaginationFilterDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Pages\Language\LanguageRepositoryInterface;

final class LanguageService
{
    private LanguageRepositoryInterface $repository;

    public function __construct(LanguageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(LanguageDto $dto): LanguageDto
    {
        $dto->setIsEditable(true);
        return $this->repository->create($dto);
    }

    public function update(array $condition, array $data): void
    {
        $this->repository->update(array_merge(array_filter($condition), ['is_editable' => true]), $data);
    }

    public function get(array $filters): ?LanguageDto
    {
        return $this->repository->get(array_filter($filters));
    }

    public function list(array $filters): ?Collection
    {
        return $this->repository->list(array_filter($filters));
    }

    public function delete(array $filters): void
    {
        $this->repository->delete(array_merge(array_filter($filters), ['is_editable' => true]));
    }

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator
    {
        $dto->setPage($dto->getPage() ?? config('app.pagination.page'));
        $dto->setPerPage($dto->getPerPage() ?? config('app.pagination.per_page'));

        return $this->repository->allByFilters($dto);
    }
}
