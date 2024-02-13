<?php

declare(strict_types=1);

namespace App\Repositories\Kyc\SessionResult;

use App\Dto\Models\Kyc\SessionResultDto;
use Illuminate\Support\Collection;

interface SessionResultRepositoryInterface
{
    public function create(SessionResultDto $dto): SessionResultDto;

    public function get(array $filters): ?SessionResultDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;
}
