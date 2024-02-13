<?php

declare(strict_types=1);

namespace App\Dto\Models\Kyc;

use App\Dto\DtoInterface;

final class ScreenDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $formUuid,
        private ?string $title,
        private ?string $subtitle,
        private ?int $sort,
        private ?string $createdAt,
        private ?string $updatedAt,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['form_uuid'] ?? null,
            $args['title'] ?? null,
            $args['subtitle'] ?? null,
            $args['sort'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'form_uuid' => $this->formUuid,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
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
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param  string|null  $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    /**
     * @param  string|null  $subtitle
     */
    public function setSubtitle(?string $subtitle): void
    {
        $this->subtitle = $subtitle;
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
    public function setSort(?int $sort): void
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
