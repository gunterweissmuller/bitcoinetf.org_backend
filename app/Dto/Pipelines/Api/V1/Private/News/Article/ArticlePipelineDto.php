<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Private\News\Article;

use App\Dto\DtoInterface;
use App\Dto\Models\News\ArticleDto;

final class ArticlePipelineDto implements DtoInterface
{
    public function __construct(
        private ?ArticleDto $article,
        private ?array $tagUuids,
        private ?string $previewFileUuid,
        private ?string $mainFileUuid,
    ) {
    }

    public function toArray(): array
    {
        return [
            'article' => $this->article,
            'tag_uuids' => $this->tagUuids,
            'preview_file_uuid' => $this->previewFileUuid,
            'main_file_uuid' => $this->mainFileUuid,
        ];
    }

    public static function fromArray(array $args): self
    {
        return new self(
            $args['article'] ?? null,
            $args['tag_uuids'] ?? null,
            $args['preview_file_uuid'] ?? null,
            $args['main_file_uuid'] ?? null
        );
    }

    /**
     * @return ArticleDto|null
     */
    public function getArticle(): ?ArticleDto
    {
        return $this->article;
    }

    /**
     * @param  ArticleDto|null  $article
     */
    public function setArticle(?ArticleDto $article): void
    {
        $this->article = $article;
    }

    /**
     * @return array|null
     */
    public function getTagUuids(): ?array
    {
        return $this->tagUuids;
    }

    /**
     * @param  array|null  $tagUuids
     */
    public function setTagUuids(?array $tagUuids): void
    {
        $this->tagUuids = $tagUuids;
    }

    /**
     * @return string|null
     */
    public function getPreviewFileUuid(): ?string
    {
        return $this->previewFileUuid;
    }

    /**
     * @param  string|null  $previewFileUuid
     */
    public function setPreviewFileUuid(?string $previewFileUuid): void
    {
        $this->previewFileUuid = $previewFileUuid;
    }

    /**
     * @return string|null
     */
    public function getMainFileUuid(): ?string
    {
        return $this->mainFileUuid;
    }

    /**
     * @param  string|null  $mainFileUuid
     */
    public function setMainFileUuid(?string $mainFileUuid): void
    {
        $this->mainFileUuid = $mainFileUuid;
    }
}
