<?php

declare(strict_types=1);

namespace App\Dto\Models\Billing;

use App\Dto\DtoInterface;

final class WithdrawalDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $accountUuid,
        private ?string $referralWalletUuid,
        private ?string $dividendWalletUuid,
        private ?float $referralAmount,
        private ?float $dividendAmount,
        private ?float $totalAmount,
        private ?float $totalAmountBtc,
        private ?float $btcPrice,
        private ?string $walletAddress,
        private ?string $status,
        private ?string $createdAt,
        private ?string $updatedAt,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['account_uuid'] ?? null,
            $args['referral_wallet_uuid'] ?? null,
            $args['dividend_wallet_uuid'] ?? null,
            $args['referral_amount'] ?? null,
            $args['dividend_amount'] ?? null,
            $args['total_amount'] ?? null,
            $args['total_amount_btc'] ?? null,
            $args['btc_price'] ?? null,
            $args['wallet_address'] ?? null,
            $args['status'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null,
        );
    }

    public function toArray(?array $without = null): array
    {
        $data = [
            'uuid' => $this->uuid,
            'account_uuid' => $this->accountUuid,
            'referral_wallet_uuid' => $this->referralWalletUuid,
            'dividend_wallet_uuid' => $this->dividendWalletUuid,
            'referral_amount' => $this->referralAmount,
            'dividend_amount' => $this->dividendAmount,
            'total_amount' => $this->totalAmount,
            'total_amount_btc' => $this->totalAmountBtc,
            'btc_price' => $this->btcPrice,
            'wallet_address' => $this->walletAddress,
            'status' => $this->status,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];

        if ($without) {
            foreach ($without as $key) {
                unset($data[$key]);
            }
        }

        return $data;
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
    public function getTotalAmount(): ?float
    {
        return $this->totalAmount;
    }

    /**
     * @param  float|null  $totalAmount
     */
    public function setTotalAmount(?float $totalAmount): void
    {
        $this->totalAmount = $totalAmount;
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

    /**
     * @return string|null
     */
    public function getWalletAddress(): ?string
    {
        return $this->walletAddress;
    }

    /**
     * @param  string|null  $walletAddress
     */
    public function setWalletAddress(?string $walletAddress): void
    {
        $this->walletAddress = $walletAddress;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param  string|null  $status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
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
}
