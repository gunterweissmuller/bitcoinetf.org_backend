<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Referrals;

use App\Dto\Models\Referrals\InviteDto;
use App\Repositories\Referrals\Invite\InviteRepositoryInterface;
use Illuminate\Support\Collection;

final class InviteService
{
    public function __construct(
        private readonly InviteRepositoryInterface $repository,
    ) {
    }

    public function create(InviteDto $dto): InviteDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?InviteDto
    {
        return $this->repository->get($filters);
    }

    public function update(array $condition, array $data): void
    {
        $this->repository->update($condition, $data);
    }

    public function all(array $filters): ?Collection
    {
        return $this->repository->all($filters);
    }

    public function delete(array $condition): void
    {
        $this->repository->delete($condition);
    }

    public function isInvite(string $accountUuid): bool
    {
        $invite = $this->repository->get([
            'account_uuid' => $accountUuid,
        ]);

        return !is_null($invite);
    }
}
