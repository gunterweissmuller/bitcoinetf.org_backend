<?php

declare(strict_types=1);

namespace App\Dto\Models\Kyc;

use App\Dto\DtoInterface;

final class SessionDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $formUuid,
        private ?string $accountUuid,
        private ?string $currentScreenUuid,
        private ?string $status,
        private ?string $createdAt,
        private ?string $updatedAt,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['form_uuid'] ?? null,
            $args['account_uuid'] ?? null,
            $args['current_screen_uuid'] ?? null,
            $args['status'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'form_uuid' => $this->formUuid,
            'account_uuid' => $this->accountUuid,
            'current_screen_uuid' => $this->currentScreenUuid,
            'status' => $this->status,
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
    public function getFormUuid(): ?string
    {
        return $this->formUuid;
    }

    /**
     * @param  string|null  $formUuid
     */
    public function setFormUuid(?string $formUuid): void
    {
        $this->formUuid = $formUuid;
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
    public function getCurrentScreenUuid(): ?string
    {
        return $this->currentScreenUuid;
    }

    /**
     * @param  string|null  $currentScreenUuid
     */
    public function setCurrentScreenUuid(?string $currentScreenUuid): void
    {
        $this->currentScreenUuid = $currentScreenUuid;
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
