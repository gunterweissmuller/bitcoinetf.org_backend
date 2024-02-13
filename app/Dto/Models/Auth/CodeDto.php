<?php

declare(strict_types=1);

namespace App\Dto\Models\Auth;

use App\Dto\DtoInterface;

final class CodeDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $accountUuid,
        private ?string $status,
        private ?string $type,
        private ?string $code,
        private ?string $revokedAt,
        private ?string $expiresAt,
        private ?string $createdAt,
        private ?string $updatedAt,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['account_uuid'] ?? null,
            $args['status'] ?? null,
            $args['type'] ?? null,
            $args['code'] ?? null,
            $args['revoked_at'] ?? null,
            $args['expires_at'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'account_uuid' => $this->accountUuid,
            'status' => $this->status,
            'type' => $this->type,
            'code' => $this->code,
            'revoked_at' => $this->revokedAt,
            'expires_at' => $this->expiresAt,
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
     * @param  string|null  $uuid
     */
    public function setUuid(?string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string|null
     */
    public function getAccountUuid(): ?string
    {
        return $this->accountUuid;
    }

    /**
     * @param  string|null  $accountUuid
     */
    public function setAccountUuid(?string $accountUuid): void
    {
        $this->accountUuid = $accountUuid;
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
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param  string|null  $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param  string|null  $code
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string|null
     */
    public function getRevokedAt(): ?string
    {
        return $this->revokedAt;
    }

    /**
     * @param  string|null  $revokedAt
     */
    public function setRevokedAt(?string $revokedAt): void
    {
        $this->revokedAt = $revokedAt;
    }

    /**
     * @return string|null
     */
    public function getExpiresAt(): ?string
    {
        return $this->expiresAt;
    }

    /**
     * @param  string|null  $expiresAt
     */
    public function setExpiresAt(?string $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
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
}
