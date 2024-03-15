<?php

declare(strict_types=1);

namespace App\Repositories\Users\Telegram;

use App\Dto\Models\Users\TelegramDto;

interface TelegramRepositoryInterface
{
    public function create(TelegramDto $dto): TelegramDto;

    public function get(array $filters): ?TelegramDto;

    public function update(array $condition, array $data): void;

    public function delete(array $condition): void;
}
