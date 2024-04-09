<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Billing;

use Illuminate\Support\Collection;
use App\Dto\Models\Billing\WalletDto;
use App\Dto\Core\PaginationFilterDto;
use App\Enums\Billing\Wallet\TypeEnum;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Billing\Wallet\WalletRepositoryInterface;

final class WalletService
{
    public function __construct(private readonly WalletRepositoryInterface $repository)
    {
    }

    public function create(WalletDto $dto): WalletDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?WalletDto
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

    public function getUserTotalBalance(string $accountUuid): float
    {
        $bonus = $this->repository->get([
            'account_uuid' => $accountUuid,
            'type' => TypeEnum::BONUS->value,
        ])?->getAmount();

        $dividends = $this->repository->get([
            'account_uuid' => $accountUuid,
            'type' => TypeEnum::DIVIDENDS->value,
        ])?->getAmount();

        $referral = $this->repository->get([
            'account_uuid' => $accountUuid,
            'type' => TypeEnum::REFERRAL->value,
        ])?->getAmount();

        $vault = $this->repository->get([
            'account_uuid' => $accountUuid,
            'type' => TypeEnum::VAULT->value,
        ])?->getAmount();

        return (float)($bonus + $dividends + $referral + $vault);
    }

    public function allByFiltersWithChunk(array $filters, int $count, callable $callback): void
    {
        $this->repository->allByFiltersWithChunk($filters, $count, $callback);
    }

    /**
     * @param string $walletUuid
     * @param float $amount
     * @return void
     */
    public function refund(string $walletUuid, float $amount): void
    {
        if ($wallet = $this->get(['uuid' => $walletUuid])) {
            $this->update([
                'uuid' => $wallet->getUuid(),
            ], [
                'amount' => $wallet->getAmount() + $amount,
            ]);
        }
    }
}
