<?php

declare(strict_types=1);

namespace App\Repositories\Pages\SectionTemplateFile;

use Illuminate\Support\Collection;
use App\Dto\Models\Pages\SectionTemplateFileDto;

interface SectionTemplateFileRepositoryInterface
{
    public function create(SectionTemplateFileDto $dto): void;

    public function update(array $condition, array $data): void;

    public function get(array $filters): ?SectionTemplateFileDto;

    public function list(array $filters): ?Collection;

    public function delete(array $filters): void;
}
