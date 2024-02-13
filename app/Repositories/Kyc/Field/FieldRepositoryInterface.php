<?php

declare(strict_types=1);

namespace App\Repositories\Kyc\Field;

use App\Dto\Models\Kyc\FieldDto;
use Illuminate\Support\Collection;

interface FieldRepositoryInterface
{
    public function create(FieldDto $dto): FieldDto;

    public function get(array $filters): ?FieldDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;
}
