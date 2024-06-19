<?php

declare(strict_types=1);

namespace App\Repositories\Newsletter\Subscription;

use App\Dto\Models\Newsletter\SubscriptionDto;
use Illuminate\Support\Collection;

interface SubscriptionRepositoryInterface
{
    public function create(SubscriptionDto $dto): SubscriptionDto;

    public function get(array $filters): ?SubscriptionDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;

    public function allByFiltersWithChunk(array $filters, int $count, callable $callback): void;
}
