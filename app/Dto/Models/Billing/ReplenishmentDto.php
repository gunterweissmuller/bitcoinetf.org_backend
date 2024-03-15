<?php

declare(strict_types=1);

namespace App\Dto\Models\Billing;

use App\Dto\DtoInterface;

final class ReplenishmentDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $accountUuid,
        private ?string $referralWalletUuid,
        private ?string $bonusWalletUuid,
        private ?string $dividendWalletUuid,
        private ?float $referralAmount,
        private ?float $bonusAmount,
        private ?float $dividendAmount,
        private ?float $dividendBtcAmount,
        private ?float $dividendUsdtAmount,
        private ?float $dividendRespAmount,
        private ?float $selectedAmount,
        private ?float $realAmount,
        private ?float $addedAmount,
        private ?float $totalAmount,
        private ?float $totalAmountBtc,
        private ?float $btcPrice,
        private ?string $status,
        private ?string $merchant001Id,
        private ?string $createdAt,
        private ?string $updatedAt,
        private ?string $orderType,
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
            $args['referral_amount'] ?? null,
            $args['bonus_amount'] ?? null,
            $args['dividend_amount'] ?? null,
            $args['dividend_btc_amount'] ?? null,
            $args['dividend_usdt_amount'] ?? null,
            $args['dividend_resp_amount'] ?? null,
            $args['selected_amount'] ?? null,
            $args['real_amount'] ?? null,
            $args['added_amount'] ?? null,
            $args['total_amount'] ?? null,
            $args['total_amount_btc'] ?? null,
            $args['btc_price'] ?? null,
            $args['status'] ?? null,
            $args['merchant001_id'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null,
            $args['order_type'] ?? null,
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
            'referral_amount' => $this->referralAmount,
            'bonus_amount' => $this->bonusAmount,
            'dividend_amount' => $this->dividendAmount,
            'dividend_btc_amount' => $this->dividendBtcAmount,
            'dividend_usdt_amount' => $this->dividendUsdtAmount,
            'dividend_resp_amount' => $this->dividendRespAmount,
            'selected_amount' => $this->selectedAmount,
            'real_amount' => $this->realAmount,
            'added_amount' => $this->addedAmount,
            'total_amount' => $this->totalAmount,
            'total_amount_btc' => $this->totalAmountBtc,
            'btc_price' => $this->btcPrice,
            'status' => $this->status,
            'merchant001_id' => $this->merchant001Id,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'order_type' => $this->orderType,
        ];
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(?string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getAccountUuid(): ?string
    {
        return $this->accountUuid;
    }

    public function setAccountUuid(?string $accountUuid): void
    {
        $this->accountUuid = $accountUuid;
    }

    public function getReferralWalletUuid(): ?string
    {
        return $this->referralWalletUuid;
    }

    public function setReferralWalletUuid(?string $referralWalletUuid): void
    {
        $this->referralWalletUuid = $referralWalletUuid;
    }

    public function getBonusWalletUuid(): ?string
    {
        return $this->bonusWalletUuid;
    }

    public function setBonusWalletUuid(?string $bonusWalletUuid): void
    {
        $this->bonusWalletUuid = $bonusWalletUuid;
    }

    public function getDividendWalletUuid(): ?string
    {
        return $this->dividendWalletUuid;
    }

    public function setDividendWalletUuid(?string $dividendWalletUuid): void
    {
        $this->dividendWalletUuid = $dividendWalletUuid;
    }

    public function getReferralAmount(): ?float
    {
        return $this->referralAmount;
    }

    public function setReferralAmount(?float $referralAmount): void
    {
        $this->referralAmount = $referralAmount;
    }

    public function getBonusAmount(): ?float
    {
        return $this->bonusAmount;
    }

    public function setBonusAmount(?float $bonusAmount): void
    {
        $this->bonusAmount = $bonusAmount;
    }

    public function getDividendAmount(): ?float
    {
        return $this->dividendAmount;
    }

    public function setDividendAmount(?float $dividendAmount): void
    {
        $this->dividendAmount = $dividendAmount;
    }

    public function getDividendBtcAmount(): ?float
    {
        return $this->dividendBtcAmount;
    }

    public function setDividendBtcAmount(?float $dividendBtcAmount): void
    {
        $this->dividendBtcAmount = $dividendBtcAmount;
    }

    public function getDividendUsdtAmount(): ?float
    {
        return $this->dividendUsdtAmount;
    }

    public function setDividendUsdtAmount(?float $dividendUsdtAmount): void
    {
        $this->dividendUsdtAmount = $dividendUsdtAmount;
    }

    public function getDividendRespAmount(): ?float
    {
        return $this->dividendRespAmount;
    }

    public function setDividendRespAmount(?float $dividendRespAmount): void
    {
        $this->dividendRespAmount = $dividendRespAmount;
    }

    public function getSelectedAmount(): ?float
    {
        return $this->selectedAmount;
    }

    public function setSelectedAmount(?float $selectedAmount): void
    {
        $this->selectedAmount = $selectedAmount;
    }

    public function getRealAmount(): ?float
    {
        return $this->realAmount;
    }

    public function setRealAmount(?float $realAmount): void
    {
        $this->realAmount = $realAmount;
    }

    public function getAddedAmount(): ?float
    {
        return $this->addedAmount;
    }

    public function setAddedAmount(?float $addedAmount): void
    {
        $this->addedAmount = $addedAmount;
    }

    public function getTotalAmount(): ?float
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(?float $totalAmount): void
    {
        $this->totalAmount = $totalAmount;
    }

    public function getTotalAmountBtc(): ?float
    {
        return $this->totalAmountBtc;
    }

    public function setTotalAmountBtc(?float $totalAmountBtc): void
    {
        $this->totalAmountBtc = $totalAmountBtc;
    }

    public function getBtcPrice(): ?float
    {
        return $this->btcPrice;
    }

    public function setBtcPrice(?float $btcPrice): void
    {
        $this->btcPrice = $btcPrice;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getMerchant001Id(): ?string
    {
        return $this->merchant001Id;
    }

    public function setMerchant001Id(?string $merchant001Id): void
    {
        $this->merchant001Id = $merchant001Id;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getOrderType(): ?string
    {
        return $this->orderType;
    }

    public function setOrderType(?string $orderType): void
    {
        $this->orderType = $orderType;
    }
    
}
