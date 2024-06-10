<?php

declare(strict_types=1);

namespace App\Dto\Models\Users;

use App\Dto\DtoInterface;

final class AccountDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?int    $number,
        private ?string $username,
        private ?string $type,
        private ?string $status,
        private ?string $password,
        private ?float  $personalBonus,
        private ?float  $increasedMinimumApy,
        private ?string $tronWallet,
        private ?bool   $fastReg,
        private ?bool   $fastPayment,
        private ?string $createdAt,
        private ?string $updatedAt,
        private ?string $providerType,
        private ?string $orderType,
    )
    {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['number'] ?? null,
            $args['username'] ?? null,
            $args['type'] ?? null,
            $args['status'] ?? null,
            $args['password'] ?? null,
            $args['personal_bonus'] ?? null,
            $args['increased_minimum_apy'] ?? null,
            $args['tron_wallet'] ?? null,
            $args['fast_reg'] ?? null,
            $args['fast_payment'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null,
            $args['provider_type'] ?? null,
            $args['order_type'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'number' => $this->number,
            'username' => $this->username,
            'type' => $this->type,
            'status' => $this->status,
            'password' => $this->password,
            'personal_bonus' => $this->personalBonus,
            'increased_minimum_apy' => $this->increasedMinimumApy,
            'tron_wallet' => $this->tronWallet,
            'fast_reg' => $this->fastReg,
            'fast_payment' => $this->fastPayment,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'provider_type' => $this->providerType,
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

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(?int $number): void
    {
        $this->number = $number;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getPersonalBonus(): ?float
    {
        return $this->personalBonus;
    }

    public function setPersonalBonus(?float $personalBonus): void
    {
        $this->personalBonus = $personalBonus;
    }

    public function getIncreasedMinimumApy(): ?float
    {
        return $this->increasedMinimumApy;
    }

    public function setIncreasedMinimumApy(?float $increasedMinimumApy): void
    {
        $this->increasedMinimumApy = $increasedMinimumApy;
    }

    public function getTronWallet(): ?string
    {
        return $this->tronWallet;
    }

    public function setTronWallet(?string $tronWallet): void
    {
        $this->tronWallet = $tronWallet;
    }

    public function getFastReg(): ?bool
    {
        return $this->fastReg;
    }

    public function setFastReg(?bool $fastReg): void
    {
        $this->fastReg = $fastReg;
    }

    public function getFastPayment(): ?bool
    {
        return $this->fastPayment;
    }

    public function setFastPayment(?bool $fastPayment): void
    {
        $this->fastPayment = $fastPayment;
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

    public function getProviderType(): ?string
    {
        return $this->providerType;
    }

    public function setProviderType(?string $providerType): void
    {
        $this->providerType = $providerType;
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
