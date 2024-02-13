<?php

declare(strict_types=1);

namespace App\Dto\Requests\V1\Public\News\Article;

use App\Dto\DtoInterface;

final class GetRequestDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $sectionSlug,
        private ?string $articleSlug,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['section_slug'] ?? null,
            $args['article_slug'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'section_slug' => $this->sectionSlug,
            'article_slug' => $this->articleSlug,
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
    public function getSectionSlug(): ?string
    {
        return $this->sectionSlug;
    }

    /**
     * @param  string|null  $sectionSlug
     */
    public function setSectionSlug(?string $sectionSlug): void
    {
        $this->sectionSlug = $sectionSlug;
    }

    /**
     * @return string|null
     */
    public function getArticleSlug(): ?string
    {
        return $this->articleSlug;
    }

    /**
     * @param  string|null  $articleSlug
     */
    public function setArticleSlug(?string $articleSlug): void
    {
        $this->articleSlug = $articleSlug;
    }
}
