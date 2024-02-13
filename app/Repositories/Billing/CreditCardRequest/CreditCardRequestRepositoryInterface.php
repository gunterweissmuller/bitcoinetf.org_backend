<?php

declare(strict_types=1);

namespace App\Repositories\Billing\CreditCardRequest;

use Illuminate\Support\Collection;
use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Billing\CreditCardRequestDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CreditCardRequestRepositoryInterface
{
    public function create(CreditCardRequestDto $dto): CreditCardRequestDto;

    public function get(array $filters): ?CreditCardRequestDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator;

    public function allByFiltersWithChunk(array $filters, int $count, callable $callback): void;

    public function total(): int;

    public function number(string $createdAt): int;
}
