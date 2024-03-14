<?php

declare(strict_types=1);

namespace App\Repositories\Pap\Tracking;

use App\Dto\Models\Pap\TrackingDto;

interface TrackingRepositoryInterface
{
    public function create(TrackingDto $dto): TrackingDto;

    public function get(array $filters): ?TrackingDto;

    public function update(array $condition, array $data): void;

    public function delete(array $condition): void;
}