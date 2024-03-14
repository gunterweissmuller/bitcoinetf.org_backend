<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Statistic;

use Illuminate\Support\Collection;
use App\Dto\Core\PaginationFilterDto;
use App\Enums\Billing\Wallet\TypeEnum;
use App\Dto\Models\Statistic\DailyWalletDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Statistic\DailyWallet\DailyWalletRepositoryInterface;

final class DailyWalletService
{
    public function __construct(private readonly DailyWalletRepositoryInterface $repository) {}

    public function create(DailyWalletDto $dto): DailyWalletDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?DailyWalletDto
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

    public function getUserTotalBalance(string $accountUuid, string $createdAt): float
    {
        $bonus = $this->repository->get([
            'account_uuid' => $accountUuid,
            'type' => TypeEnum::BONUS->value,
            ['created_at', '>=', $createdAt],
        ])?->getAmount();

        $dividends = $this->repository->get([
            'account_uuid' => $accountUuid,
            'type' => TypeEnum::DIVIDENDS->value,
            ['created_at', '>=', $createdAt],
        ])?->getAmount();

        $referral = $this->repository->get([
            'account_uuid' => $accountUuid,
            'type' => TypeEnum::REFERRAL->value,
            ['created_at', '>=', $createdAt],
        ])?->getAmount();

        $vault = $this->repository->get([
            'account_uuid' => $accountUuid,
            'type' => TypeEnum::VAULT->value,
            ['created_at', '>=', $createdAt],
        ])?->getAmount();

        return (float) ($bonus + $dividends + $referral + $vault);
    }
}
