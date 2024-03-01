<?php

declare(strict_types=1);

namespace App\Repositories\Users\AppleAccount;

use App\Dto\Models\Users\AppleAccountDto;

interface AppleAccountRepositoryInterface
{
    public function create(AppleAccountDto $dto): AppleAccountDto;

    public function get(array $filters): ?AppleAccountDto;

    public function update(array $condition, array $data): void;

    public function delete(array $condition): void;
}
