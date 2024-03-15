<?php

declare(strict_types=1);

namespace App\Dto\Models\Statistic;

use App\Dto\DtoInterface;

final class DailyAumDto implements DtoInterface
{
    public function __construct(
        private readonly ?string $uuid,
        private readonly ?float $amount,
        private readonly ?string $createdAt,
    ) {}

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['amount'] ?? null,
            $args['created_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'amount' => $this->amount,
            'created_at' => $this->createdAt,
        ];
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }
}
