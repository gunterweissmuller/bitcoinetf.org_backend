<?php

declare(strict_types=1);

namespace App\Dto\Models\Newsletter;

use App\Dto\DtoInterface;

final class SubscriptionDto implements DtoInterface
{
    /**
     * @param string|null $uuid
     * @param string|null $email
     * @param bool|null $sent
     * @param string|null $createdAt
     * @param string|null $updatedAt
     */
    public function __construct(
        private ?string $uuid,
        private ?string $email,
        private ?bool   $sent,
        private ?string $createdAt,
        private ?string $updatedAt,
    )
    {
    }

    /**
     * @param array $args
     * @return DtoInterface|self
     */
    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['email'] ?? null,
            $args['sent'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null,
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'email' => $this->email,
            'sent' => $this->sent,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    /**
     * @return string|null
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @param string|null $uuid
     */
    public function setUuid(?string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return bool|null
     */
    public function getSent(): ?bool
    {
        return $this->sent;
    }

    /**
     * @param bool|null $sent
     * @return void
     */
    public function setSent(?bool $sent): void
    {
        $this->sent = $sent;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @param string|null $createdAt
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
     * @param string|null $updatedAt
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
