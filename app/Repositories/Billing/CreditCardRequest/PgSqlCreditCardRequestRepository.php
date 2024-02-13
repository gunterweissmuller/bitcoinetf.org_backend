<?php

declare(strict_types=1);

namespace App\Repositories\Billing\CreditCardRequest;

use App\Enums\Billing\CreditCardRequest\StatusEnum;
use Illuminate\Support\Collection;
use App\Dto\Core\PaginationFilterDto;
use App\Models\Billing\CreditCardRequest;
use App\Dto\Models\Billing\CreditCardRequestDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class PgSqlCreditCardRequestRepository implements CreditCardRequestRepositoryInterface
{
    public function __construct(private readonly CreditCardRequest $model) {}

    public function create(CreditCardRequestDto $dto): CreditCardRequestDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return CreditCardRequestDto::fromArray($model->toArray());
    }

    public function get(array $filters): ?CreditCardRequestDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? CreditCardRequestDto::fromArray($model->toArray()) : null;
    }

    public function update(array $condition, array $data): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->update($data);
    }

    public function all(array $filters): ?Collection
    {
        $rows = $this->model
            ->newQuery()
            ->where($filters)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();

        return $rows ? Collection::make($rows)->map(function (array $row) {
            return CreditCardRequestDto::fromArray($row);
        }) : null;
    }

    public function delete(array $condition): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->delete();
    }

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator
    {
        return $this->model
            ->newQuery()
            ->where($dto->getFilters() ?? [])
            ->orderBy('created_at', 'desc')
            ->paginate($dto->getPerPage(), ['*'], 'page', $dto->getPage());
    }

    public function allByFiltersWithChunk(array $filters, int $count, callable $callback): void
    {
        $this->model
            ->newQuery()
            ->where($filters)
            ->orderBy('created_at', 'desc')
            ->chunk($count, $callback);
    }

    public function total(): int
    {
        return $this->model
            ->newQuery()
            ->where('status', '=', StatusEnum::PENDING->value)
            ->count();
    }

    public function number(string $createdAt): int
    {
        return $this->model
            ->newQuery()
            ->where('status', '=', StatusEnum::PENDING->value)
            ->where('created_at', '<=', $createdAt)
            ->count();
    }
}
