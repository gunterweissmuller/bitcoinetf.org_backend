<?php

declare(strict_types=1);

namespace App\Repositories\Billing\Payment;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Billing\PaymentDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface PaymentRepositoryInterface
{
    public function create(PaymentDto $dto): PaymentDto;

    public function get(array $filters): ?PaymentDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters, ?array $nullableFields): ?Collection;

    public function delete(array $condition): void;

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator;

    public function getSum(string $column, array $filters): float;

    public function getCount(array $filters): float;

    public function getLastPayment(PaymentDto $dto): ?PaymentDto;

    public function getGroupingSumByMonth(array $filters, int $limit = 6): ?Collection;

    public function getSumInPeriod(string $column, array $filters, string $from, string $to): float;
}
