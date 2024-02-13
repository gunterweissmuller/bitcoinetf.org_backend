<?php

declare(strict_types=1);

namespace App\Repositories\Kyc\SessionFile;

use App\Dto\Models\Kyc\SessionFileDTO;
use Illuminate\Support\Collection;

interface SessionFileRepositoryInterface
{
    public function create(SessionFileDTO $dto): SessionFileDTO;

    public function get(array $filters): ?SessionFileDTO;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;
}
