<?php

declare(strict_types=1);

namespace App\Dto\Models\Statistic;

use App\Dto\DtoInterface;

final class DailyWalletDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $accountUuid,
        private ?string $type,
        private ?float $amount,
        private ?string $createdAt,
    ) {}

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['account_uuid'] ?? null,
            $args['type'] ?? null,
            $args['amount'] ?? null,
            $args['created_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'account_uuid' => $this->accountUuid,
            'type' => $this->type,
            'amount' => $this->amount,
            'created_at' => $this->createdAt,
        ];
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getAccountUuid(): ?string
    {
        return $this->accountUuid;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }
}
