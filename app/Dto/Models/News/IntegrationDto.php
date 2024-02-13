<?php

declare(strict_types=1);

namespace App\Dto\Models\News;

use App\Dto\DtoInterface;

final class IntegrationDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $name,
        private ?string $publicKey,
        private ?string $privateKey,
        private ?string $link,
        private ?string $status,
        private ?string $createdAt,
        private ?string $updatedAt,
    )
    {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['name'] ?? null,
            $args['public_key'] ?? null,
            $args['private_key'] ?? null,
            $args['link'] ?? null,
            $args['status'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'public_key' => $this->publicKey,
            'private_key' => $this->privateKey,
            'link' => $this->link,
            'status' => $this->status,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(?string $value): void
    {
        $this->uuid = $value;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPublicKey(): ?string
    {
        return $this->publicKey;
    }

    public function getPrivateKey(): ?string
    {
        return $this->privateKey;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function getStatus(): ?string
    {
        return $this->status;
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
