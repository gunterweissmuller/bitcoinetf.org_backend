<?php

declare(strict_types=1);

namespace App\Repositories\Billing\Payment;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Billing\PaymentDto;
use App\Models\Billing\Payment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class PgSqlPaymentRepository implements PaymentRepositoryInterface
{
    public function __construct(private readonly Payment $model)
    {
    }

    public function create(PaymentDto $dto): PaymentDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return PaymentDto::fromArray($model->toArray());
    }

    public function get(array $filters): ?PaymentDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? PaymentDto::fromArray($model->toArray()) : null;
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
            return PaymentDto::fromArray($row);
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

    public function getSum(string $column, array $filters): float
    {
        return (float) $this->model
            ->newQuery()
            ->where($filters)
            ->sum($column);
    }

    public function getCount(array $filters): float
    {
        return (float) $this->model
            ->newQuery()
            ->where($filters)
            ->count();
    }

    public function getLastPayment(PaymentDto $dto): ?PaymentDto
    {
        $model = $this->model
            ->newQuery()
            ->where(array_filter($dto->toArray()))
            ->orderBy('created_at', 'desc')
            ->first();

        return $model ? PaymentDto::fromArray($model->toArray()) : null;
    }

    public function getGroupingSumByMonth(array $filters, int $limit = 6): ?Collection
    {
        return $this->model
            ->newQuery()
            ->select(
                DB::raw('sum(dividend_amount)'),
                DB::raw("TO_CHAR(created_at, 'yyyy-mm') as date"),
                DB::raw('sum(total_amount_btc) as sum_btc')
            )
            ->where($filters)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->limit($limit)
            ->get();
    }

    public function getSumInPeriod(string $column, array $filters, string $from, string $to): float
    {
        return (float) $this->model
            ->newQuery()
            ->where($filters)
            ->where('created_at', '>=', $from)
            ->where('created_at', '<=', $to)
            ->sum($column);
    }
}
