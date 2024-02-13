<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Auth;

use App\Dto\Core\JWTDto;
use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Auth\RefreshTokenDto;
use App\Enums\Auth\RefreshToken\StatusEnum;
use App\Repositories\Auth\RefreshToken\RefreshTokenRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class RefreshTokenService
{
    public function __construct(
        private readonly RefreshTokenRepositoryInterface $repository,
    ) {
    }

    public function create(string $accountUuid, JWTDto $dto): RefreshTokenDto
    {
        return $this->repository->create(RefreshTokenDto::fromArray([
            'account_uuid' => $accountUuid,
            'token' => $dto->getToken(),
            'status' => StatusEnum::Unused->value,
            'expires_at' => $dto->getExpiresIn(),
        ]));
    }

    public function get(array $filters): ?RefreshTokenDto
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

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator
    {
        $dto->setPage($dto->getPage() ?? config('app.pagination.page'));
        $dto->setPerPage($dto->getPerPage() ?? config('app.pagination.per_page'));

        return $this->repository->allByFilters($dto);
    }
}
