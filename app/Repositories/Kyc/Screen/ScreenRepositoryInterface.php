<?php

declare(strict_types=1);

namespace App\Repositories\Kyc\Screen;

use App\Dto\Models\Kyc\ScreenDto;
use Illuminate\Support\Collection;

interface ScreenRepositoryInterface
{
    public function create(ScreenDto $dto): ScreenDto;

    public function get(array $filters): ?ScreenDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;
}
