<?php

declare(strict_types=1);

namespace App\Repositories\Users\Facebook;

use App\Dto\Models\Users\FacebookDto;

interface FacebookRepositoryInterface
{
    public function create(FacebookDto $dto): FacebookDto;

    public function get(array $filters): ?FacebookDto;

    public function update(array $condition, array $data): void;

    public function delete(array $condition): void;
}
