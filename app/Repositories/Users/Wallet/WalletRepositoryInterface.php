<?php

declare(strict_types=1);

namespace App\Repositories\Users\Wallet;

use App\Dto\Models\Users\WalletDto;

interface WalletRepositoryInterface
{
    public function create(WalletDto $dto): WalletDto;

    public function get(array $filters): ?WalletDto;

    public function update(array $condition, array $data): void;

    public function delete(array $condition): void;
}
