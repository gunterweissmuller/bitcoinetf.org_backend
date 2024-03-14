<?php

declare(strict_types=1);

namespace App\Dto\Models\Apollopayment;

use App\Dto\DtoInterface;

final class ClientsDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $accountUuid,
        private ?string $client_id,
        private ?string $webhook_url,
        private ?string $ethereum_addr,
        private ?string $tron_addr,
        private ?string $polygon_addr,
        private ?string $createdAt,
        private ?string $updatedAt,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['account_uuid'] ?? null,
            $args['client_id'] ?? null,
            $args['webhook_url'] ?? null,
            $args['ethereum_addr'] ?? null,
            $args['tron_addr'] ?? null,
            $args['polygon_addr'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'account_uuid' => $this->accountUuid,
            'client_id' => $this->client_id,
            'webhook_url' => $this->webhook_url,
            'ethereum_addr' => $this->ethereum_addr,
            'tron_addr' => $this->tron_addr,
            'polygon_addr' => $this->polygon_addr,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
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

    public function getAccountUuid(): ?string
    {
        return $this->accountUuid;
    }

    public function setAccountUuid(?string $accountUuid): void
    {
        $this->accountUuid = $accountUuid;
    }

    public function getClientId(): ?string
    {
        return $this->client_id;
    }

    public function setClientId(?string $client_id): void
    {
        $this->client_id = $client_id;
    }

    public function getWebhookUrl(): ?string
    {
        return $this->webhook_url;
    }

    public function setWebhookUrl(?string $webhook_url): void
    {
        $this->webhook_url = $webhook_url;
    }

    public function getEthereumAddr(): ?string
    {
        return $this->ethereum_addr;
    }

    public function setEthereumAddr(?string $ethereum_addr): void
    {
        $this->ethereum_addr = $ethereum_addr;
    }

    public function getTronAddr(): ?string
    {
        return $this->tron_addr;
    }

    public function setTronAddr(?string $tron_addr): void
    {
        $this->tron_addr = $tron_addr;
    }

    public function getPolygonAddr(): ?string
    {
        return $this->polygon_addr;
    }

    public function setPolygonAddr(?string $polygon_addr): void
    {
        $this->polygon_addr = $polygon_addr;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
