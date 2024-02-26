<?php

declare(strict_types=1);

namespace App\Dto\Models\Billing;

use App\Dto\DtoInterface;

final class WalletDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $accountUuid,
        private ?string $type,
        private ?float $amount,
        private ?string $withdrawalAddress,
        private ?string $withdrawalMethod,
        private ?string $createdAt,
        private ?string $updatedAt,
        private ?float  $btcAmount,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['account_uuid'] ?? null,
            $args['type'] ?? null,
            $args['amount'] ?? null,
            $args['withdrawal_address'] ?? null,
            $args['withdrawal_method'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null,
            $args['btc_amount'] ?? null,
        );
    }

    public function toArray(?array $without = null): array
    {
        $data = [
            'uuid' => $this->uuid,
            'account_uuid' => $this->accountUuid,
            'type' => $this->type,
            'amount' => $this->amount,
            'withdrawal_address' => $this->withdrawalAddress,
            'withdrawal_method' => $this->withdrawalMethod,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'btc_amount' => $this->btcAmount,
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

    public function getBtcAmount(): ?float
    {
        return $this->btcAmount;
    }

    public function setBtcAmount(?float $value): void
    {
        $this->btcAmount = $value;
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
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @param  float|null  $amount
     */
    public function setAmount(?float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string|null
     */
    public function getWithdrawalAddress(): ?string
    {
        return $this->withdrawalAddress;
    }

    /**
     * @param  string|null  $withdrawalAddress
     */
    public function setWithdrawalAddress(?string $withdrawalAddress): void
    {
        $this->withdrawalAddress = $withdrawalAddress;
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
