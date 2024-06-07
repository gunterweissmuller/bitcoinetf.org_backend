<?php

declare(strict_types=1);

namespace App\Repositories\Users\Metadata;

use App\Dto\Models\Users\MetadataDto;

interface MetadataRepositoryInterface
{
    public function create(MetadataDto $dto): MetadataDto;

    public function get(array $filters): ?MetadataDto;

    public function update(array $condition, array $data): void;

    public function delete(array $condition): void;
}
