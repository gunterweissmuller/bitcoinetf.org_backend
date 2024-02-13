<?php

declare(strict_types=1);

namespace App\Dto\Models\Kyc;

use App\Dto\DtoInterface;

final class FieldOptionDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $fieldUuid,
        private ?string $label,
        private ?string $value,
        private ?string $createdAt,
        private ?string $updatedAt,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['field_uuid'] ?? null,
            $args['label'] ?? null,
            $args['value'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'field_uuid' => $this->fieldUuid,
            'label' => $this->label,
            'value' => $this->value,
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
    public function getFieldUuid(): ?string
    {
        return $this->fieldUuid;
    }

    /**
     * @param  string|null  $fieldUuid
     */
    public function setFieldUuid(?string $fieldUuid): void
    {
        $this->fieldUuid = $fieldUuid;
    }

    /**
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param  string|null  $label
     */
    public function setLabel(?string $label): void
    {
        $this->label = $label;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param  string|null  $value
     */
    public function setValue(?string $value): void
    {
        $this->value = $value;
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
