<?php

declare(strict_types=1);

namespace App\Repositories\Pages\SectionTemplate;

use Illuminate\Support\Collection;
use App\Dto\Models\Pages\SectionTemplateDto;

interface SectionTemplateRepositoryInterface
{
    public function create(SectionTemplateDto $dto): SectionTemplateDto;

    public function update(array $condition, array $data): void;

    public function get(array $filters): ?SectionTemplateDto;

    public function list(array $filters): ?Collection;

    public function delete(array $filters): void;
}
