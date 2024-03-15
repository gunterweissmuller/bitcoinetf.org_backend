<?php

declare(strict_types=1);

namespace App\Dto\Models\Kyc;

use App\Dto\DtoInterface;

final class FieldDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $screenUuid,
        private ?string $name,
        private ?string $label,
        private ?string $type,
        private ?bool $required,
        private null|string|array $enums,
        private ?int $sort,
        private ?string $createdAt,
        private ?string $updatedAt,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['screen_uuid'] ?? null,
            $args['name'] ?? null,
            $args['label'] ?? null,
            $args['type'] ?? null,
            $args['required'] ?? null,
            $args['enums'] ?? null,
            $args['sort'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'screen_uuid' => $this->screenUuid,
            'name' => $this->name,
            'label' => $this->label,
            'type' => $this->type,
            'required' => $this->required,
            'enums' => $this->enums,
            'sort' => $this->sort,
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
     * @return bool|null
     */
    public function getRequired(): ?bool
    {
        return $this->required;
    }

    /**
     * @param  bool|null  $required
     */
    public function setRequired(?bool $required): void
    {
        $this->required = $required;
    }

    /**
     * @return array|string|null
     */
    public function getEnums(): array|string|null
    {
        return $this->enums;
    }

    /**
     * @param  array|string|null  $enums
     */
    public function setEnums(array|string|null $enums): void
    {
        $this->enums = $enums;
    }

    /**
     * @return int|null
     */
    public function getSort(): ?int
    {
        return $this->sort;
    }

    /**
     * @param  int|null  $sort
     */
    public function setSort(?string $sort): void
    {
        $this->sort = $sort;
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
