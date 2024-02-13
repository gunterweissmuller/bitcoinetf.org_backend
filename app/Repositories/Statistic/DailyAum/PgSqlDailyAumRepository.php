<?php

declare(strict_types=1);

namespace App\Repositories\Statistic\DailyAum;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Statistic\DailyAumDto;
use App\Models\Statistic\DailyAum;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class PgSqlDailyAumRepository implements DailyAumRepositoryInterface
{
    public function __construct(
        private readonly DailyAum $model,
    ) {
    }

    public function create(DailyAumDto $dto): DailyAumDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return DailyAumDto::fromArray($model->toArray());
    }

    public function get(array $filters): ?DailyAumDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->first();

        return $model ? DailyAumDto::fromArray($model->toArray()) : null;
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
            return DailyAumDto::fromArray($row);
        }) : null;
    }

    public function delete(array $condition): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->delete();
    }

    public function allByFilters(PaginationFilterDto $dto): Collection
    {
        return $this->model
            ->newQuery()
            ->select([DB::raw('sum(amount) as amount'), 'created_at'])
            ->where($dto->getFilters() ?? [])
            ->groupBy(['created_at'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getLast(array $filters): ?DailyAumDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->orderBy('created_at', 'DESC')
            ->first();

        return $model ? DailyAumDto::fromArray($model->toArray()) : null;
    }
}
