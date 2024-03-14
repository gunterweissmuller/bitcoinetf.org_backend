<?php

declare(strict_types=1);

namespace App\Repositories\Kyc\FieldOption;

use App\Dto\Models\Kyc\FieldOptionDto;
use Illuminate\Support\Collection;

interface FieldOptionRepositoryInterface
{
    public function create(FieldOptionDto $dto): FieldOptionDto;

    public function get(array $filters): ?FieldOptionDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;
}
