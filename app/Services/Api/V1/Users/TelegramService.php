<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Users;

use App\Dto\Models\Users\TelegramDto;
use App\Repositories\Users\Telegram\TelegramRepositoryInterface;

final class TelegramService
{
    public function __construct(
        private readonly TelegramRepositoryInterface $repository,
    ) {
    }

    public function create(TelegramDto $dto): TelegramDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?TelegramDto
    {
        return $this->repository->get($filters);
    }

    public function update(array $condition, array $data): void
    {
        $this->repository->update($condition, $data);
    }

    public function delete(array $condition): void
    {
        $this->repository->delete($condition);
    }
}
