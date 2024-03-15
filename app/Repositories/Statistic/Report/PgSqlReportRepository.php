<?php

declare(strict_types=1);

namespace App\Repositories\Statistic\Report;

use App\Dto\Core\PaginationFilterDto;
use App\Models\Statistic\Report;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Dto\Models\Statistic\ReportDto;

final class PgSqlReportRepository implements ReportRepositoryInterface
{
    public function __construct(private readonly Report $model) {}

    public function create(ReportDto $dto): ReportDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return ReportDto::fromArray($model->toArray());
    }

    public function get(array $filters, array $with = []): ?ReportDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->with($with)
            ->orderBy('created_at', 'desc')
            ->first();

        return $model ? ReportDto::fromArray($model->toArray()) : null;
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
            return ReportDto::fromArray($row);
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
}
