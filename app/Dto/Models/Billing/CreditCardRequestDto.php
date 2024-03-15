<?php

declare(strict_types=1);

namespace App\Dto\Models\Billing;

use App\Dto\DtoInterface;

final class CreditCardRequestDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $accountUuid,
        private ?string $status,
        private ?string $createdAt,
        private ?string $updatedAt,
    ) {}

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['account_uuid'] ?? null,
            $args['status'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'account_uuid' => $this->accountUuid,
            'status' => $this->status,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }
}
