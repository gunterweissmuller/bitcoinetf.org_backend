<?php

declare(strict_types=1);

namespace App\Dto\Models\Apollopayment;

use App\Dto\DtoInterface;

final class WebhooksDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $client_id,
        private ?string $webhook_id,
        private ?string $address_id,
        private ?float  $amount,
        private ?string $currency,
        private ?string $network,
        private ?string $tx,
        private ?string $type,
        private ?string $createdAt,
        private ?string $updatedAt,
        private ?string $payload,
    )
    {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['client_id'] ?? null,
            $args['webhook_id'] ?? null,
            $args['address_id'] ?? null,
            $args['amount'] ?? null,
            $args['currency'] ?? null,
            $args['network'] ?? null,
            $args['tx'] ?? null,
            $args['type'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null,
            $args['payload'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'client_id' => $this->client_id,
            'webhook_id' => $this->webhook_id,
            'address_id' => $this->address_id,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'network' => $this->network,
            'tx' => $this->tx,
            'type' => $this->type,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'payload' => $this->payload,
        ];
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(?string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getClientId(): ?string
    {
        return $this->client_id;
    }

    public function setClientId(?string $client_id): void
    {
        $this->client_id = $client_id;
    }

    public function getWebhookId(): ?string
    {
        return $this->webhook_id;
    }

    public function setWebhookId(?string $webhook_id): void
    {
        $this->webhook_id = $webhook_id;
    }

    public function getAddressId(): ?string
    {
        return $this->address_id;
    }

    public function setAddressId(?string $address_id): void
    {
        $this->address_id = $address_id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): void
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

    public function getNetwork(): ?string
    {
        return $this->network;
    }

    public function setNetwork(?string $network): void
    {
        $this->network = $network;
    }

    public function getTx(): ?string
    {
        return $this->tx;
    }

    public function setTx(?string $tx): void
    {
        $this->tx = $tx;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @param  string|null  $createdAt
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * @param  string|null  $updatedAt
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string|null
     */
    public function getPayload(): ?string
    {
        return $this->payload;
    }

    /**
     * @param  string|null  $payload
     */
    public function setPayload(?string $payload): void
    {
        $this->payload = $payload;
    }

}
