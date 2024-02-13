<?php

declare(strict_types=1);

namespace App\Repositories\Pages\SectionFile;

use Illuminate\Support\Collection;
use App\Dto\Models\Pages\SectionFileDto;

interface SectionFileRepositoryInterface
{
    public function create(SectionFileDto $dto): void;

    public function update(array $condition, array $data): void;

    public function get(array $filters): ?SectionFileDto;

    public function list(array $filters): ?Collection;

    public function delete(array $filters): void;
}
