<?php

declare(strict_types=1);

namespace App\Repositories\Kyc\SessionFile;

use App\Dto\Models\Kyc\SessionFileDTO;
use App\Models\Kyc\SessionFile;
use Illuminate\Support\Collection;

final class PgSqlSessionFileRepository implements SessionFileRepositoryInterface
{
    public function __construct(
        private readonly SessionFile $model,
    ) {
    }

    public function create(SessionFileDTO $dto): SessionFileDTO
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return SessionFileDTO::fromArray($model->toArray());
    }

    public function get(array $filters, array $order = []): ?SessionFileDTO
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->orderBy('created_at', 'desc')
            ->first();

        return $model ? SessionFileDTO::fromArray($model->toArray()) : null;
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
            return SessionFileDTO::fromArray($row);
        }) : null;
    }

    public function delete(array $condition): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->delete();
    }
}
