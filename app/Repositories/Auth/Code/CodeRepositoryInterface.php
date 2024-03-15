<?php

declare(strict_types=1);

namespace App\Repositories\Auth\Code;

use App\Dto\Models\Auth\CodeDto;
use Illuminate\Support\Collection;

interface CodeRepositoryInterface
{
    public function create(CodeDto $dto): CodeDto;

    public function get(array $filters): ?CodeDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;
}
