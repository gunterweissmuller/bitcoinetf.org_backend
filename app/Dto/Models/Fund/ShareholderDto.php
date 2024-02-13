<?php

declare(strict_types=1);

namespace App\Dto\Models\Fund;

use App\Dto\DtoInterface;
use App\Dto\Models\Users\AccountDto;

final class ShareholderDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $accountUuid,
        private ?float  $totalPayments,
        private ?float  $totalDividends,
        private ?string $createdAt,
        private ?string $updatedAt,
        private ?AccountDto $account
    )
    {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['account_uuid'] ?? null,
            $args['total_payments'] ?? null,
            $args['total_dividends'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null,
            isset($args['account']) ? AccountDto::fromArray($args['account']) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'account_uuid' => $this->accountUuid,
            'total_payments' => $this->totalPayments,
            'total_dividends' => $this->totalDividends,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'account' => $this->account?->toArray(),
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

    public function getTotalPayments(): ?float
    {
        return $this->totalPayments;
    }

    public function getTotalDividends(): ?float
    {
        return $this->totalDividends;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function getAccount(): ?AccountDto
    {
        return $this->account;
    }
}
