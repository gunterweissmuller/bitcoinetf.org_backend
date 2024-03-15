<?php

declare(strict_types=1);

namespace App\Dto\Models\News;

use App\Dto\DtoInterface;

final class ArticleFileDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $articleUuid,
        private ?string $fileUuid,
        private ?string $type,
        private ?string $createdAt,
        private ?string $updatedAt,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['article_uuid'] ?? null,
            $args['file_uuid'] ?? null,
            $args['type'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'article_uuid' => $this->articleUuid,
            'file_uuid' => $this->fileUuid,
            'type' => $this->type,
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
    public function getArticleUuid(): ?string
    {
        return $this->articleUuid;
    }

    /**
     * @param  string|null  $articleUuid
     */
    public function setArticleUuid(?string $articleUuid): void
    {
        $this->articleUuid = $articleUuid;
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
