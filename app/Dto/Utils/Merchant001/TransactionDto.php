<?php

namespace App\Dto\Utils\Merchant001;

use App\Dto\DtoInterface;

class TransactionDto implements DtoInterface
{
    public function __construct(
        private ?string $id,
        private ?string $status,
        private ?string $invoiceId,
        private ?string $amount,
        private ?string $currency,
        private ?string $signature,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['id'] ?? null,
            $args['status'] ?? null,
            $args['invoice_id'] ?? null,
            $args['amount'] ?? null,
            $args['currency'] ?? null,
            $args['signature'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'invoice_id' => $this->invoiceId,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'signature' => $this->signature,
        ];
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getInvoiceId(): ?string
    {
        return $this->invoiceId;
    }

    public function setInvoiceId(?string $invoiceId): void
    {
        $this->invoiceId = $invoiceId;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(?string $amount): void
    {
        $this->amount = $amount;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): void
    {
        $this->currency = $currency;
    }

    public function getSignature(): ?string
    {
        return $this->signature;
    }

    public function setSignature(?string $signature): void
    {
        $this->signature = $signature;
    }
}
