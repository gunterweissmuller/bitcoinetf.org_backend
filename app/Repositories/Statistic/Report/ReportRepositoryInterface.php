<?php

declare(strict_types=1);

namespace App\Repositories\Statistic\Report;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Statistic\ReportDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ReportRepositoryInterface
{
    public function create(ReportDto $dto): ReportDto;

    public function get(array $filters): ?ReportDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator;
}
