<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Utils\Greenfield;

use App\Dto\DtoInterface;

final class LightningInvoiceDto implements DtoInterface
{
    public function __construct(
        private ?string $id,
        private ?string $status,
        private ?string $bolt11,
        private ?int $paidAt,
        private ?int $expiresAt,
        private ?string $amount,
        private ?string $amountReceived,
        private ?string $paymentHash,
        private ?string $preimage,
        private ?array $customRecords,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['id'] ?? null,
            $args['status'] ?? null,
            $args['BOLT11'] ?? null,
            $args['paidAt'] ?? null,
            $args['expiresAt'] ?? null,
            $args['amount'] ?? null,
            $args['amountReceived'] ?? null,
            $args['paymentHash'] ?? null,
            $args['preimage'] ?? null,
            $args['customRecords'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'BOLT11' => $this->bolt11,
            'paidAt' => $this->paidAt,
            'expiresAt' => $this->expiresAt,
            'amount' => $this->amount,
            'amountReceived' => $this->amountReceived,
            'paymentHash' => $this->paymentHash,
            'preimage' => $this->preimage,
            'customRecords' => $this->customRecords,
        ];
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param  string|null  $id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param  string|null  $status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string|null
     */
    public function getBolt11(): ?string
    {
        return $this->bolt11;
    }

    /**
     * @param  string|null  $bolt11
     */
    public function setBolt11(?string $bolt11): void
    {
        $this->bolt11 = $bolt11;
    }

    /**
     * @return int|null
     */
    public function getPaidAt(): ?int
    {
        return $this->paidAt;
    }

    /**
     * @param  int|null  $paidAt
     */
    public function setPaidAt(?int $paidAt): void
    {
        $this->paidAt = $paidAt;
    }

    /**
     * @return int|null
     */
    public function getExpiresAt(): ?int
    {
        return $this->expiresAt;
    }

    /**
     * @param  int|null  $expiresAt
     */
    public function setExpiresAt(?int $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    /**
     * @return string|null
     */
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    /**
     * @param  string|null  $amount
     */
    public function setAmount(?string $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string|null
     */
    public function getAmountReceived(): ?string
    {
        return $this->amountReceived;
    }

    /**
     * @param  string|null  $amountReceived
     */
    public function setAmountReceived(?string $amountReceived): void
    {
        $this->amountReceived = $amountReceived;
    }

    /**
     * @return string|null
     */
    public function getPaymentHash(): ?string
    {
        return $this->paymentHash;
    }

    /**
     * @param  string|null  $paymentHash
     */
    public function setPaymentHash(?string $paymentHash): void
    {
        $this->paymentHash = $paymentHash;
    }

    /**
     * @return string|null
     */
    public function getPreimage(): ?string
    {
        return $this->preimage;
    }

    /**
     * @param  string|null  $preimage
     */
    public function setPreimage(?string $preimage): void
    {
        $this->preimage = $preimage;
    }

    /**
     * @return array|null
     */
    public function getCustomRecords(): ?array
    {
        return $this->customRecords;
    }

    /**
     * @param  array|null  $customRecords
     */
    public function setCustomRecords(?array $customRecords): void
    {
        $this->customRecords = $customRecords;
    }
}
