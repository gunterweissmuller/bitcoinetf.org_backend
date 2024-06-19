<?php

declare(strict_types=1);

namespace App\Repositories\Newsletter\Subscription;

use App\Dto\Models\Newsletter\SubscriptionDto;
use App\Models\Newsletter\Subscription;
use Illuminate\Support\Collection;

final class PgSqlSubscriptionRepository implements SubscriptionRepositoryInterface
{
    /**
     * @param Subscription $model
     */
    public function __construct(
        private readonly Subscription $model,
    )
    {
    }

    /**
     * @param SubscriptionDto $dto
     * @return SubscriptionDto
     */
    public function create(SubscriptionDto $dto): SubscriptionDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return SubscriptionDto::fromArray($model->toArray());
    }

    /**
     * @param array $filters
     * @param array $order
     * @return SubscriptionDto|null
     */
    public function get(array $filters, array $order = []): ?SubscriptionDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? SubscriptionDto::fromArray($model->toArray()) : null;
    }

    /**
     * @param array $condition
     * @param array $data
     * @return void
     */
    public function update(array $condition, array $data): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->update($data);
    }

    /**
     * @param array $filters
     * @return Collection|null
     */
    public function all(array $filters): ?Collection
    {
        $rows = $this->model
            ->newQuery()
            ->where($filters)
            ->get()
            ->toArray();

        return $rows ? Collection::make($rows)->map(function (array $row) {
            return SubscriptionDto::fromArray($row);
        }) : null;
    }

    /**
     * @param array $condition
     * @return void
     */
    public function delete(array $condition): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->delete();
    }

    /**
     * @param array $filters
     * @param int $count
     * @param callable $callback
     * @return void
     */
    public function allByFiltersWithChunk(array $filters, int $count, callable $callback): void
    {
        $this->model
            ->newQuery()
            ->where($filters)
            ->orderBy('created_at', 'desc')
            ->chunk($count, $callback);
    }
}
