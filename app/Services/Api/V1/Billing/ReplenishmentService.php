<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Billing;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Billing\ReplenishmentDto;
use App\Enums\Billing\Replenishment\StatusEnum;
use App\Repositories\Billing\Replenishment\ReplenishmentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class ReplenishmentService
{
    public function __construct(
        private readonly ReplenishmentRepositoryInterface $repository
    ) {
    }

    public function create(ReplenishmentDto $dto): ReplenishmentDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters, callable $callback = null): ?ReplenishmentDto
    {
        return $this->repository->get($filters, $callback);
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

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator
    {
        $dto->setPage($dto->getPage() ?? config('app.pagination.page'));
        $dto->setPerPage($dto->getPerPage() ?? config('app.pagination.per_page'));

        return $this->repository->allByFilters($dto);
    }

    /**
     * @param string $replenishmentUuid
     * @return void
     */
    public function cancelReplenishment(string $replenishmentUuid)
    {
        if ($replenishment = $this->get([
            'status' => StatusEnum::INIT->value,
            'uuid' => $replenishmentUuid,
        ])) {
            $this->update([
                'uuid' => $replenishment->getUuid(),
            ], [
                'status' => StatusEnum::EXPIRED->value,
            ]);
        }
    }
}
