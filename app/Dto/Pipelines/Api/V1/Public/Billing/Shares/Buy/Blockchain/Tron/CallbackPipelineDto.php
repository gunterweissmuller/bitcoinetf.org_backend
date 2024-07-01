<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Blockchain\Tron;

use App\Dto\DtoInterface;
use App\Dto\Models\Billing\ReplenishmentDto;
use App\Dto\Models\Users\AccountDto;

class CallbackPipelineDto implements DtoInterface
{
    public function __construct(
        private ?AccountDto $account,
        private ?ReplenishmentDto $replenishment,
        private ?bool $isReplenishment,
        private ?bool $checkTrcBonus,
    ) {
    }

    public static function fromArray(array $args): self
    {
        return new self(
            $args['account'] ?? null,
            $args['replenishment'] ?? null,
            $args['is_replenishment'] ?? false,
            $args['check_trc_bonus'] ?? true,
        );
    }

    public function toArray(): array
    {
        return [
            'account' => $this->account,
            'replenishment' => $this->replenishment,
            'is_replenishment' => $this->isReplenishment,
            'check_trc_bonus' => $this->checkTrcBonus,
        ];
    }

    public function getAccount(): ?AccountDto
    {
        return $this->account;
    }

    public function setAccount(?AccountDto $account): void
    {
        $this->account = $account;
    }

    public function getReplenishment(): ?ReplenishmentDto
    {
        return $this->replenishment;
    }

    public function setReplenishment(?ReplenishmentDto $replenishment): void
    {
        $this->replenishment = $replenishment;
    }

    public function isReplenishment(): ?bool
    {
        return $this->isReplenishment;
    }

    public function setIsReplenishment(bool $isReplenishment): void
    {
        $this->isReplenishment = $isReplenishment;
    }

    /**
     * @return bool|null
     */
    public function getCheckTrcBonus(): ?bool
    {
        return $this->checkTrcBonus;
    }

    /**
     * @param bool $checkTrcBonus
     * @return void
     */
    public function setCheckTrcBonus(bool $checkTrcBonus): void
    {
        $this->checkTrcBonus = $checkTrcBonus;
    }
}
