<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy;

use App\Dto\DtoInterface;
use App\Dto\Models\Billing\ReplenishmentDto;
use App\Dto\Models\Billing\WalletDto;
use App\Dto\Models\Users\AccountDto;

final class InitPipelineDto implements DtoInterface
{
    public function __construct(
        private ?AccountDto $account,
        private WalletDto|bool $dividends,
        private WalletDto|bool $referral,
        private WalletDto|bool $bonus,
        private ReplenishmentDto $replenishment,
    ) {
    }

    public static function fromArray(array $args): self
    {
        return new self(
            $args['account'] ?? null,
            $args['dividends'] ?? false,
            $args['referral'] ?? false,
            $args['bonus'] ?? false,
            $args['replenishment'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'account' => $this->account,
            'dividends' => $this->dividends,
            'referral' => $this->referral,
            'bonus' => $this->bonus,
            'replenishment' => $this->replenishment,
        ];
    }

    /**
     * @return AccountDto|null
     */
    public function getAccount(): ?AccountDto
    {
        return $this->account;
    }

    /**
     * @param  AccountDto|null  $account
     */
    public function setAccount(?AccountDto $account): void
    {
        $this->account = $account;
    }

    /**
     * @return WalletDto|bool
     */
    public function getDividends(): bool|WalletDto
    {
        return $this->dividends;
    }

    /**
     * @param  WalletDto|bool  $dividends
     */
    public function setDividends(bool|WalletDto $dividends): void
    {
        $this->dividends = $dividends;
    }

    /**
     * @return WalletDto|bool
     */
    public function getReferral(): bool|WalletDto
    {
        return $this->referral;
    }

    /**
     * @param  WalletDto|bool  $referral
     */
    public function setReferral(bool|WalletDto $referral): void
    {
        $this->referral = $referral;
    }

    /**
     * @return WalletDto|bool
     */
    public function getBonus(): bool|WalletDto
    {
        return $this->bonus;
    }

    /**
     * @param  WalletDto|bool  $bonus
     */
    public function setBonus(bool|WalletDto $bonus): void
    {
        $this->bonus = $bonus;
    }

    /**
     * @return ReplenishmentDto
     */
    public function getReplenishment(): ReplenishmentDto
    {
        return $this->replenishment;
    }

    /**
     * @param  ReplenishmentDto  $replenishment
     */
    public function setReplenishment(ReplenishmentDto $replenishment): void
    {
        $this->replenishment = $replenishment;
    }
}
