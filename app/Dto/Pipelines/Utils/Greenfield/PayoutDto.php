<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Utils\Greenfield;

use App\Dto\DtoInterface;

final class PayoutDto implements DtoInterface
{
    public function __construct(
        private ?string $id,
        private ?int $revision,
        private ?string $pullPaymentId,
        private ?int $date,
        private ?string $destination,
        private ?float $amount,
        private ?string $paymentMethod,
        private ?string $cryptoCode,
        private ?float $paymentMethodAmount,
        private ?string $state,
        private ?array $paymentProof,
        private ?array $metadata,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['id'] ?? null,
            $args['revision'] ?? null,
            $args['pullPaymentId'] ?? null,
            $args['date'] ?? null,
            $args['destination'] ?? null,
            $args['amount'] ?? null,
            $args['paymentMethod'] ?? null,
            $args['cryptoCode'] ?? null,
            $args['paymentMethodAmount'] ?? null,
            $args['state'] ?? null,
            $args['paymentProof'] ?? null,
            $args['metadata'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'revision' => $this->revision,
            'pullPaymentId' => $this->pullPaymentId,
            'date' => $this->date,
            'destination' => $this->destination,
            'amount' => $this->amount,
            'paymentMethod' => $this->paymentMethod,
            'cryptoCode' => $this->cryptoCode,
            'paymentMethodAmount' => $this->paymentMethodAmount,
            'state' => $this->state,
            'paymentProof' => $this->paymentProof,
            'metadata' => $this->metadata,
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
     * @return int|null
     */
    public function getRevision(): ?int
    {
        return $this->revision;
    }

    /**
     * @param  int|null  $revision
     */
    public function setRevision(?int $revision): void
    {
        $this->revision = $revision;
    }

    /**
     * @return string|null
     */
    public function getPullPaymentId(): ?string
    {
        return $this->pullPaymentId;
    }

    /**
     * @param  string|null  $pullPaymentId
     */
    public function setPullPaymentId(?string $pullPaymentId): void
    {
        $this->pullPaymentId = $pullPaymentId;
    }

    /**
     * @return int|null
     */
    public function getDate(): ?int
    {
        return $this->date;
    }

    /**
     * @param  int|null  $date
     */
    public function setDate(?int $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string|null
     */
    public function getDestination(): ?string
    {
        return $this->destination;
    }

    /**
     * @param  string|null  $destination
     */
    public function setDestination(?string $destination): void
    {
        $this->destination = $destination;
    }

    /**
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @param  float|null  $amount
     */
    public function setAmount(?float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string|null
     */
    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    /**
     * @param  string|null  $paymentMethod
     */
    public function setPaymentMethod(?string $paymentMethod): void
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * @return string|null
     */
    public function getCryptoCode(): ?string
    {
        return $this->cryptoCode;
    }

    /**
     * @param  string|null  $cryptoCode
     */
    public function setCryptoCode(?string $cryptoCode): void
    {
        $this->cryptoCode = $cryptoCode;
    }

    /**
     * @return float|null
     */
    public function getPaymentMethodAmount(): ?float
    {
        return $this->paymentMethodAmount;
    }

    /**
     * @param  float|null  $paymentMethodAmount
     */
    public function setPaymentMethodAmount(?float $paymentMethodAmount): void
    {
        $this->paymentMethodAmount = $paymentMethodAmount;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param  string|null  $state
     */
    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    /**
     * @return array|null
     */
    public function getPaymentProof(): ?array
    {
        return $this->paymentProof;
    }

    /**
     * @param  array|null  $paymentProof
     */
    public function setPaymentProof(?array $paymentProof): void
    {
        $this->paymentProof = $paymentProof;
    }

    /**
     * @return array|null
     */
    public function getMetadata(): ?array
    {
        return $this->metadata;
    }

    /**
     * @param  array|null  $metadata
     */
    public function setMetadata(?array $metadata): void
    {
        $this->metadata = $metadata;
    }
}
