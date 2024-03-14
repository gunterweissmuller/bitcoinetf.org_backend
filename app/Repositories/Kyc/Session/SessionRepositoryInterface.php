<?php

declare(strict_types=1);

namespace App\Repositories\Kyc\Session;

use App\Dto\Models\Kyc\SessionDto;
use Illuminate\Support\Collection;

interface SessionRepositoryInterface
{
    public function create(SessionDto $dto): SessionDto;

    public function get(array $filters): ?SessionDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;
}
