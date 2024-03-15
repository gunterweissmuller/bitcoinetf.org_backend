<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Utils\Greenfield;

use App\Dto\DtoInterface;

final class CreateLightningInvoiceDto implements DtoInterface
{
    public function __construct(
        private ?string $amount,
        private ?string $description,
        private ?bool $descriptionHashOnly,
        private ?int $expiry,
        private ?bool $privateRouteHints,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['amount'] ?? null,
            $args['description'] ?? null,
            $args['descriptionHashOnly'] ?? null,
            $args['expiry'] ?? null,
            $args['privateRouteHints'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'description' => $this->description,
            'descriptionHashOnly' => $this->descriptionHashOnly,
            'expiry' => $this->expiry,
            'privateRouteHints' => $this->privateRouteHints,
        ];
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
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param  string|null  $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return bool|null
     */
    public function getDescriptionHashOnly(): ?bool
    {
        return $this->descriptionHashOnly;
    }

    /**
     * @param  bool|null  $descriptionHashOnly
     */
    public function setDescriptionHashOnly(?bool $descriptionHashOnly): void
    {
        $this->descriptionHashOnly = $descriptionHashOnly;
    }

    /**
     * @return int|null
     */
    public function getExpiry(): ?int
    {
        return $this->expiry;
    }

    /**
     * @param  int|null  $expiry
     */
    public function setExpiry(?int $expiry): void
    {
        $this->expiry = $expiry;
    }

    /**
     * @return bool|null
     */
    public function getPrivateRouteHints(): ?bool
    {
        return $this->privateRouteHints;
    }

    /**
     * @param  bool|null  $privateRouteHints
     */
    public function setPrivateRouteHints(?bool $privateRouteHints): void
    {
        $this->privateRouteHints = $privateRouteHints;
    }
}
