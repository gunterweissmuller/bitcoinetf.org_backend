<?php

declare(strict_types=1);

namespace App\Repositories\Storage\File;

use App\Dto\Models\Storage\FileDto;
use Illuminate\Support\Collection;

interface FileRepositoryInterface
{
    public function create(FileDto $dto): FileDto;

    public function update(array $condition, array $data): void;

    public function get(array $filters): ?FileDto;

    public function list(array $filters, callable $callback = null): ?Collection;

    public function delete(array $filters): void;

    public function count(array $filters): int;
}
