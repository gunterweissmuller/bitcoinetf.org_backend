<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Newsletter;

use App\Dto\Models\Newsletter\SubscriptionDto;
use App\Repositories\Newsletter\Subscription\SubscriptionRepositoryInterface;
use Illuminate\Support\Collection;

final class SubscriptionService
{
    /**
     * @param SubscriptionRepositoryInterface $repository
     */
    public function __construct(
        private readonly SubscriptionRepositoryInterface $repository,
    )
    {
    }

    /**
     * @param SubscriptionDto $dto
     * @return SubscriptionDto
     */
    public function create(SubscriptionDto $dto): SubscriptionDto
    {
        return $this->repository->create($dto);
    }

    /**
     * @param array $filters
     * @return SubscriptionDto|null
     */
    public function get(array $filters): ?SubscriptionDto
    {
        return $this->repository->get($filters);
    }

    /**
     * @param array $condition
     * @param array $data
     * @return void
     */
    public function update(array $condition, array $data): void
    {
        $this->repository->update($condition, $data);
    }

    /**
     * @param array $filters
     * @return Collection|null
     */
    public function all(array $filters): ?Collection
    {
        return $this->repository->all($filters);
    }

    /**
     * @param array $condition
     * @return void
     */
    public function delete(array $condition): void
    {
        $this->repository->delete($condition);
    }

    /**
     * @param array $filters
     * @param int $count
     * @param callable $callback
     * @return void
     */
    public function allByFiltersWithChunk(array $filters, int $count, callable $callback): void
    {
        $this->repository->allByFiltersWithChunk($filters, $count, $callback);
    }
}
