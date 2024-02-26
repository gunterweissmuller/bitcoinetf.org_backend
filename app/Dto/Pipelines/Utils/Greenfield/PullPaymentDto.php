<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Utils\Greenfield;

use App\Dto\DtoInterface;

final class PullPaymentDto implements DtoInterface
{
    public function __construct(
        private ?string $id,
        private ?string $name,
        private ?string $description,
        private ?string $currency,
        private ?float $amount,
        private ?int $period,
        private ?int $bolt11Expiration,
        private ?bool $autoApproveClaims,
        private ?bool $archived,
        private ?string $viewLink,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['id'] ?? null,
            $args['name'] ?? null,
            $args['description'] ?? null,
            $args['currency'] ?? null,
            $args['amount'] ?? null,
            $args['period'] ?? null,
            $args['BOLT11Expiration'] ?? null,
            $args['autoApproveClaims'] ?? null,
            $args['archived'] ?? null,
            $args['viewLink'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'currency' => $this->currency,
            'amount' => $this->amount,
            'period' => $this->period,
            'BOLT11Expiration' => $this->bolt11Expiration,
            'autoApproveClaims' => $this->autoApproveClaims,
            'archived' => $this->archived,
            'viewLink' => $this->viewLink,
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param  string|null  $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
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
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param  string|null  $currency
     */
    public function setCurrency(?string $currency): void
    {
        $this->currency = $currency;
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
     * @return int|null
     */
    public function getPeriod(): ?int
    {
        return $this->period;
    }

    /**
     * @param  int|null  $period
     */
    public function setPeriod(?int $period): void
    {
        $this->period = $period;
    }

    /**
     * @return int|null
     */
    public function getBolt11Expiration(): ?int
    {
        return $this->bolt11Expiration;
    }

    /**
     * @param  int|null  $bolt11Expiration
     */
    public function setBolt11Expiration(?int $bolt11Expiration): void
    {
        $this->bolt11Expiration = $bolt11Expiration;
    }

    /**
     * @return bool|null
     */
    public function getAutoApproveClaims(): ?bool
    {
        return $this->autoApproveClaims;
    }

    /**
     * @param  bool|null  $autoApproveClaims
     */
    public function setAutoApproveClaims(?bool $autoApproveClaims): void
    {
        $this->autoApproveClaims = $autoApproveClaims;
    }

    /**
     * @return bool|null
     */
    public function getArchived(): ?bool
    {
        return $this->archived;
    }

    /**
     * @param  bool|null  $archived
     */
    public function setArchived(?bool $archived): void
    {
        $this->archived = $archived;
    }

    /**
     * @return string|null
     */
    public function getViewLink(): ?string
    {
        return $this->viewLink;
    }

    /**
     * @param  string|null  $viewLink
     */
    public function setViewLink(?string $viewLink): void
    {
        $this->viewLink = $viewLink;
    }
}
