<?php

declare(strict_types=1);

namespace App\Dto\Models\Billing;

use App\Dto\DtoInterface;

final class TokenDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $name,
        private ?string $symbol,
        private ?float $amount,
        private ?string $createdAt,
        private ?string $updatedAt,
    )
    {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['name'] ?? null,
            $args['symbol'] ?? null,
            $args['amount'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'symbol' => $this->symbol,
            'amount' => $this->amount,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }
}
