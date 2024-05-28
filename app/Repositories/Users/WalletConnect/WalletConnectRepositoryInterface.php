<?php

declare(strict_types=1);

namespace App\Repositories\Users\WalletConnect;

use App\Dto\Models\Users\WalletConnectDto;

interface WalletConnectRepositoryInterface
{
    public function create(WalletConnectDto $dto): WalletConnectDto;

    public function get(array $filters): ?WalletConnectDto;

    public function update(array $condition, array $data): void;

    public function delete(array $condition): void;
}
