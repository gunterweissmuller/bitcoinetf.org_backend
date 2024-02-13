<?php

declare(strict_types=1);

namespace App\Repositories\Statistic\DailyAum;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Statistic\DailyAumDto;
use Illuminate\Support\Collection;

interface DailyAumRepositoryInterface
{
    public function create(DailyAumDto $dto): DailyAumDto;

    public function get(array $filters): ?DailyAumDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;

    public function allByFilters(PaginationFilterDto $dto): Collection;

    public function getLast(array $filters): ?DailyAumDto;
}
