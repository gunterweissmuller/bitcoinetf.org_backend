<?php

declare(strict_types=1);

namespace App\Dto\Models\Kyc;

use App\Dto\DtoInterface;

final class SessionFileDTO implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $sessionUuid,
        private ?string $fileUuid,
        private ?string $createdAt,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['session_uuid'] ?? null,
            $args['file_uuid'] ?? null,
            $args['created_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'session_uuid' => $this->sessionUuid,
            'file_uuid' => $this->fileUuid,
            'created_at' => $this->createdAt,
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
    public function getSessionUuid(): ?string
    {
        return $this->sessionUuid;
    }

    /**
     * @param  string|null  $sessionUuid
     */
    public function setSessionUuid(?string $sessionUuid): void
    {
        $this->sessionUuid = $sessionUuid;
    }

    /**
     * @return string|null
     */
    public function getFileUuid(): ?string
    {
        return $this->fileUuid;
    }

    /**
     * @param  string|null  $fileUuid
     */
    public function setFileUuid(?string $fileUuid): void
    {
        $this->fileUuid = $fileUuid;
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
}
