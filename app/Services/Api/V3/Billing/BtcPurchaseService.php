<?php

declare(strict_types=1);

namespace App\Services\Api\V3\Billing;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Billing\BtcPurchaseDto;
use App\Enums\Billing\Payment\TypeEnum;
use App\Repositories\Billing\BtcPurchase\BtcPurchaseRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class BtcPurchaseService
{
    public function __construct(private readonly BtcPurchaseRepositoryInterface $repository)
    {
    }

    public function create(BtcPurchaseDto $dto): BtcPurchaseDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?BtcPurchaseDto
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

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator
    {
        $dto->setPage($dto->getPage() ?? config('app.pagination.page'));
        $dto->setPerPage($dto->getPerPage() ?? config('app.pagination.per_page'));

        return $this->repository->allByFilters($dto);
    }

    public function allByFiltersWithChunk(array $filters, int $count, callable $callback): void
    {
        $this->repository->allByFiltersWithChunk($filters, $count, $callback);
    }

}
