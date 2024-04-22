<?php

declare(strict_types=1);

namespace App\Services\Api\V3\Apollopayment;


use App\Dto\Models\Apollopayment\ClientsDto;
use App\Repositories\Apollopayment\Clients\ClientsRepositoryInterface;

final class ApollopaymentClientsService
{
    public function __construct(
        private readonly ClientsRepositoryInterface $repository,
    )
    {
    }

    public function create(ClientsDto $dto): ClientsDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?ClientsDto
    {
        return $this->repository->get($filters);
    }

    public function update(array $condition, array $data): void
    {
        $this->repository->update($condition, $data);
    }

    public function delete(array $condition): void
    {
        $this->repository->delete($condition);
    }

    public function allByFiltersWithChunk(array $filters, int $count, callable $callback): void
    {
        $this->repository->allByFiltersWithChunk($filters, $count, $callback);
    }

    public function deleteDuplicate(array $condition, string $uuid): void
    {
        $this->repository->deleteDuplicate($condition, $uuid);
    }
}
