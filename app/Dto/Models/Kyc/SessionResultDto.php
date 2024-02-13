<?php

declare(strict_types=1);

namespace App\Dto\Models\Kyc;

use App\Dto\DtoInterface;

final class SessionResultDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $sessionUuid,
        private ?string $screenUuid,
        private string|array|null $data,
        private ?string $createdAt,
        private ?string $updatedAt,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['session_uuid'] ?? null,
            $args['screen_uuid'] ?? null,
            $args['data'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'session_uuid' => $this->sessionUuid,
            'screen_uuid' => $this->screenUuid,
            'data' => $this->data,
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
    public function getScreenUuid(): ?string
    {
        return $this->screenUuid;
    }

    /**
     * @param  string|null  $screenUuid
     */
    public function setScreenUuid(?string $screenUuid): void
    {
        $this->screenUuid = $screenUuid;
    }

    /**
     * @return array|string|null
     */
    public function getData(): array|string|null
    {
        return $this->data;
    }

    /**
     * @param  array|string|null  $data
     */
    public function setData(array|string|null $data): void
    {
        $this->data = $data;
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
