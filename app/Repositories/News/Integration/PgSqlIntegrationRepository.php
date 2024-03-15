<?php

declare(strict_types=1);

namespace App\Repositories\News\Integration;

use App\Models\News\Integration;
use Illuminate\Support\Collection;
use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\News\IntegrationDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class PgSqlIntegrationRepository implements IntegrationRepositoryInterface
{
    public function __construct(
        private readonly Integration $model,
    ) {
    }

    public function create(IntegrationDto $dto): IntegrationDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return IntegrationDto::fromArray($model->toArray());
    }

    public function get(array $filters): ?IntegrationDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? IntegrationDto::fromArray($model->toArray()) : null;
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
            return IntegrationDto::fromArray($row);
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
            ->orderBy('created_at', 'desc')
            ->paginate($dto->getPerPage(), ['*'], 'page', $dto->getPage());
    }
}
