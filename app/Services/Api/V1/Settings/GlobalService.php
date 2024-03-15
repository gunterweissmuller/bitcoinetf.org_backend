<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Settings;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Settings\GlobalDto;
use App\Enums\Settings\Global\SymbolEnum;
use App\Repositories\Settings\Global\GlobalRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class GlobalService
{
    private GlobalRepositoryInterface $repository;

    public function __construct(GlobalRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(GlobalDto $dto): GlobalDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?GlobalDto
    {
        return $this->repository->get($filters);
    }

    public function list(array $filters): ?Collection
    {
        return $this->repository->list($filters);
    }

    public function update(array $condition, array $data): void
    {
        $this->repository->update($condition, $data);
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

    public function getMinimumApyValue($increased = false): ?float
    {
        $percent = (float) $this->repository->get([
            'symbol' => SymbolEnum::MINIMUM_APY->value,
        ])->getValue();

        if ($increased) {
            $percent += $this->repository->get([
                'symbol' => SymbolEnum::INCREASED_MINIMUM_APY->value,
            ])->getValue();
        }

        return $percent;
    }

    public function getIncreasedMinimumApyValue($increased = false): ?float
    {
        return $this->repository->get([
            'symbol' => SymbolEnum::INCREASED_MINIMUM_APY->value,
        ])->getValue();
    }

    public function getProjectedApyValue(): ?float
    {
        return $this->repository->get([
            'symbol' => SymbolEnum::PROJECTED_APY->value,
        ])->getValue();
    }

    public function getDefaultBonusValue(): ?float
    {
        return (float) $this->repository->get([
            'symbol' => SymbolEnum::DEFAULT_BONUS->value,
        ])->getValue();
    }

    public function getTrcBonus(): ?float
    {
        return (float) $this->repository->get([
            'symbol' => SymbolEnum::TRC_BONUS->value,
        ])->getValue();
    }

    public function getTrcBonusDecrease(): ?string
    {
        return $this->repository->get([
            'symbol' => SymbolEnum::TRC_BONUS_DECREASE->value,
        ])->getValue();
    }

    public function getKycBonusValue(): ?float
    {
        return (float) $this->repository->get([
            'symbol' => SymbolEnum::KYC_BONUS->value,
        ])->getValue();
    }

    public function getRussiaBonusValue(): ?float
    {
        return (float) $this->repository->get([
            'symbol' => SymbolEnum::RUSSIA_BONUS->value,
        ])->getValue();
    }

    public function getMerchant001StatusValue(): ?bool
    {
        return (bool) $this->repository->get([
            'symbol' => SymbolEnum::MERCHANT001_STATUS->value,
        ])->getValue();
    }

    public function getMinReplenishmentAmount(): ?int
    {
        return (int) $this->repository->get([
            'symbol' => SymbolEnum::MIN_REPLENISHMENT_AMOUNT->value,
        ])->getValue();
    }
}
