<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Utils\Greenfield;

use App\Dto\DtoInterface;

final class PayLightningInvoiceDto implements DtoInterface
{
    public function __construct(
        private ?string $id,
        private ?string $status,
        private ?string $bolt11,
        private ?string $paymentHash,
        private ?string $preimage,
        private ?int $createdAt,
        private ?string $totalAmount,
        private ?string $feeAmount,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['id'] ?? null,
            $args['status'] ?? null,
            $args['BOLT11'] ?? null,
            $args['paymentHash'] ?? null,
            $args['preimage'] ?? null,
            $args['createdAt'] ?? null,
            $args['totalAmount'] ?? null,
            $args['feeAmount'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'BOLT11' => $this->bolt11,
            'paymentHash' => $this->paymentHash,
            'preimage' => $this->preimage,
            'createdAt' => $this->createdAt,
            'totalAmount' => $this->totalAmount,
            'feeAmount' => $this->feeAmount,
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
     * @return int|null
     */
    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
    }

    /**
     * @param  int|null  $createdAt
     */
    public function setCreatedAt(?int $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string|null
     */
    public function getTotalAmount(): ?string
    {
        return $this->totalAmount;
    }

    /**
     * @param  string|null  $totalAmount
     */
    public function setTotalAmount(?string $totalAmount): void
    {
        $this->totalAmount = $totalAmount;
    }

    /**
     * @return string|null
     */
    public function getFeeAmount(): ?string
    {
        return $this->feeAmount;
    }

    /**
     * @param  string|null  $feeAmount
     */
    public function setFeeAmount(?string $feeAmount): void
    {
        $this->feeAmount = $feeAmount;
    }
}
