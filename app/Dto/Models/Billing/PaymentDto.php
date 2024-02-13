<?php

declare(strict_types=1);

namespace App\Dto\Models\Billing;

use App\Dto\DtoInterface;

final class PaymentDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $accountUuid,
        private ?string $referralWalletUuid,
        private ?string $bonusWalletUuid,
        private ?string $dividendWalletUuid,
        private ?string $vaultWalletUuid,
        private ?float $referralAmount,
        private ?float $bonusAmount,
        private ?float $dividendAmount,
        private ?float $vaultAmount,
        private ?float $realAmount,
        private ?string $type,
        private ?string $createdAt,
        private ?string $updatedAt,
        private ?float $totalAmountBtc,
        private ?float $btcPrice,
        private ?string $withdrawalMethod,
        private ?string $descType,
        private ?string $payday,
        private ?string $codeUuid,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['account_uuid'] ?? null,
            $args['referral_wallet_uuid'] ?? null,
            $args['bonus_wallet_uuid'] ?? null,
            $args['dividend_wallet_uuid'] ?? null,
            $args['vault_wallet_uuid'] ?? null,
            $args['referral_amount'] ?? null,
            $args['bonus_amount'] ?? null,
            $args['dividend_amount'] ?? null,
            $args['vault_amount'] ?? null,
            $args['real_amount'] ?? null,
            $args['type'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null,
            $args['total_amount_btc'] ?? null,
            $args['btc_price'] ?? null,
            $args['withdrawal_method'] ?? null,
            $args['desc_type'] ?? null,
            $args['payday'] ?? null,
            $args['code_uuid'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'account_uuid' => $this->accountUuid,
            'referral_wallet_uuid' => $this->referralWalletUuid,
            'bonus_wallet_uuid' => $this->bonusWalletUuid,
            'dividend_wallet_uuid' => $this->dividendWalletUuid,
            'vault_wallet_uuid' => $this->vaultWalletUuid,
            'referral_amount' => $this->referralAmount,
            'bonus_amount' => $this->bonusAmount,
            'dividend_amount' => $this->dividendAmount,
            'vault_amount' => $this->vaultAmount,
            'real_amount' => $this->realAmount,
            'type' => $this->type,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'total_amount_btc' => $this->totalAmountBtc,
            'btc_price' => $this->btcPrice,
            'withdrawal_method' => $this->withdrawalMethod,
            'desc_type' => $this->descType,
            'payday' => $this->payday,
            'code_uuid' => $this->codeUuid,
        ];
    }

    /**
     * @return string|null
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @param  string|null  $uuid
     */
    public function setUuid(?string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string|null
     */
    public function getAccountUuid(): ?string
    {
        return $this->accountUuid;
    }

    /**
     * @param  string|null  $accountUuid
     */
    public function setAccountUuid(?string $accountUuid): void
    {
        $this->accountUuid = $accountUuid;
    }

    /**
     * @return string|null
     */
    public function getReferralWalletUuid(): ?string
    {
        return $this->referralWalletUuid;
    }

    /**
     * @param  string|null  $referralWalletUuid
     */
    public function setReferralWalletUuid(?string $referralWalletUuid): void
    {
        $this->referralWalletUuid = $referralWalletUuid;
    }

    /**
     * @return string|null
     */
    public function getBonusWalletUuid(): ?string
    {
        return $this->bonusWalletUuid;
    }

    /**
     * @param  string|null  $bonusWalletUuid
     */
    public function setBonusWalletUuid(?string $bonusWalletUuid): void
    {
        $this->bonusWalletUuid = $bonusWalletUuid;
    }

    /**
     * @return string|null
     */
    public function getDividendWalletUuid(): ?string
    {
        return $this->dividendWalletUuid;
    }

    /**
     * @param  string|null  $dividendWalletUuid
     */
    public function setDividendWalletUuid(?string $dividendWalletUuid): void
    {
        $this->dividendWalletUuid = $dividendWalletUuid;
    }

    /**
     * @return string|null
     */
    public function getVaultWalletUuid(): ?string
    {
        return $this->vaultWalletUuid;
    }

    /**
     * @param  string|null  $vaultWalletUuid
     */
    public function setVaultWalletUuid(?string $vaultWalletUuid): void
    {
        $this->vaultWalletUuid = $vaultWalletUuid;
    }

    /**
     * @return float|null
     */
    public function getReferralAmount(): ?float
    {
        return $this->referralAmount;
    }

    /**
     * @param  float|null  $referralAmount
     */
    public function setReferralAmount(?float $referralAmount): void
    {
        $this->referralAmount = $referralAmount;
    }

    /**
     * @return float|null
     */
    public function getBonusAmount(): ?float
    {
        return $this->bonusAmount;
    }

    /**
     * @param  float|null  $bonusAmount
     */
    public function setBonusAmount(?float $bonusAmount): void
    {
        $this->bonusAmount = $bonusAmount;
    }

    /**
     * @return float|null
     */
    public function getDividendAmount(): ?float
    {
        return $this->dividendAmount;
    }

    /**
     * @param  float|null  $dividendAmount
     */
    public function setDividendAmount(?float $dividendAmount): void
    {
        $this->dividendAmount = $dividendAmount;
    }

    /**
     * @return float|null
     */
    public function getVaultAmount(): ?float
    {
        return $this->vaultAmount;
    }

    /**
     * @param  float|null  $vaultAmount
     */
    public function setVaultAmount(?float $vaultAmount): void
    {
        $this->vaultAmount = $vaultAmount;
    }

    /**
     * @return float|null
     */
    public function getRealAmount(): ?float
    {
        return $this->realAmount;
    }

    /**
     * @param  float|null  $realAmount
     */
    public function setRealAmount(?float $realAmount): void
    {
        $this->realAmount = $realAmount;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param  string|null  $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @param  string|null  $createdAt
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * @param  string|null  $updatedAt
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return float|null
     */
    public function getTotalAmountBtc(): ?float
    {
        return $this->totalAmountBtc;
    }

    /**
     * @param  float|null  $totalAmountBtc
     */
    public function setTotalAmountBtc(?float $totalAmountBtc): void
    {
        $this->totalAmountBtc = $totalAmountBtc;
    }

    /**
     * @return float|null
     */
    public function getBtcPrice(): ?float
    {
        return $this->btcPrice;
    }

    /**
     * @param  float|null  $btcPrice
     */
    public function setBtcPrice(?float $btcPrice): void
    {
        $this->btcPrice = $btcPrice;
    }

    public function getTotalAmount(): ?float
    {
        return $this->referralAmount +
            $this->bonusAmount +
            $this->dividendAmount +
            $this->realAmount;
    }

    /**
     * @return string|null
     */
    public function getWithdrawalMethod(): ?string
    {
        return $this->withdrawalMethod;
    }

    /**
     * @param  string|null  $withdrawalMethod
     */
    public function setWithdrawalMethod(?string $withdrawalMethod): void
    {
        $this->withdrawalMethod = $withdrawalMethod;
    }

    /**
     * @return string|null
     */
    public function getDescType(): ?string
    {
        return $this->descType;
    }

    /**
     * @param  string|null  $descType
     */
    public function setDescType(?string $descType): void
    {
        $this->descType = $descType;
    }

    /**
     * @return string|null
     */
    public function getPayday(): ?string
    {
        return $this->payday;
    }

    /**
     * @param  string|null  $payday
     */
    public function setPayday(?string $payday): void
    {
        $this->payday = $payday;
    }

    /**
     * @return string|null
     */
    public function getCodeUuid(): ?string
    {
        return $this->codeUuid;
    }

    /**
     * @param  string|null  $codeUuid
     */
    public function setCodeUuid(?string $codeUuid): void
    {
        $this->codeUuid = $codeUuid;
    }
}
