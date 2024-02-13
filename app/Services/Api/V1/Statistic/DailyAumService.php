<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Statistic;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Statistic\DailyAumDto;
use App\Repositories\Statistic\DailyAum\DailyAumRepositoryInterface;
use Illuminate\Support\Collection;

final class DailyAumService
{
    public function __construct(private readonly DailyAumRepositoryInterface $repository)
    {
    }

    public function create(DailyAumDto $dto): DailyAumDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?DailyAumDto
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

    public function allByFilters(PaginationFilterDto $dto): Collection
    {
        //$dto->setPage($dto->getPage() ?? config('app.pagination.page'));
        //$dto->setPerPage($dto->getPerPage() ?? config('app.pagination.per_page'));

        return $this->repository->allByFilters($dto);
    }

    public function getLast(array $filters): ?DailyAumDto
    {
        return $this->repository->getLast($filters);
    }
}
