<?php

declare(strict_types=1);

namespace App\Dto\Models\News;

use App\Dto\DtoInterface;

final class ArticleTagDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $articleUuid,
        private ?string $tagUuid,
        private ?string $createdAt,
        private ?string $updatedAt,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['article_uuid'] ?? null,
            $args['tag_uuid'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'article_uuid' => $this->articleUuid,
            'tag_uuid' => $this->tagUuid,
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
    public function getTagUuid(): ?string
    {
        return $this->tagUuid;
    }

    /**
     * @param  string|null  $tagUuid
     */
    public function setTagUuid(?string $tagUuid): void
    {
        $this->tagUuid = $tagUuid;
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
