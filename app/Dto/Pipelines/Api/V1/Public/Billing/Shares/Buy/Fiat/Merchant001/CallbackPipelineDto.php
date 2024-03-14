<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Fiat\Merchant001;

use App\Dto\DtoInterface;
use App\Dto\Models\Billing\ReplenishmentDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Utils\Merchant001\TransactionDto;

final class CallbackPipelineDto implements DtoInterface
{
    public function __construct(
        private ?AccountDto $account,
        private ?TransactionDto $transaction,
        private ?ReplenishmentDto $replenishment,
        private ?string $status,
        private ?bool $isReplenished,
    ) {
    }

    public static function fromArray(array $args): self
    {
        return new self(
            $args['account'] ?? null,
            $args['transaction'] ?? null,
            $args['replenishment'] ?? null,
            $args['status'] ?? null,
            $args['is_replenished'] ?? false,
        );
    }

    public function toArray(): array
    {
        return [
            'account' => $this->account,
            'transaction' => $this->transaction,
            'replenishment' => $this->replenishment,
            'status' => $this->status,
            'is_replenished' => $this->isReplenished,
        ];
    }

    public function getAccount(): ?AccountDto
    {
        return $this->account;
    }

    public function setAccount(?AccountDto $account): void
    {
        $this->account = $account;
    }

    public function getTransaction(): ?TransactionDto
    {
        return $this->transaction;
    }

    public function setTransaction(?TransactionDto $transaction): void
    {
        $this->transaction = $transaction;
    }

    public function getReplenishment(): ?ReplenishmentDto
    {
        return $this->replenishment;
    }

    public function setReplenishment(?ReplenishmentDto $replenishment): void
    {
        $this->replenishment = $replenishment;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function isReplenished(): ?bool
    {
        return $this->isReplenished;
    }

    public function setIsReplenished(?bool $isReplenished): void
    {
        $this->isReplenished = $isReplenished;
    }
}
