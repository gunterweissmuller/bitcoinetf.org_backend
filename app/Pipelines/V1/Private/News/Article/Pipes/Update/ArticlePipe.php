<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\News\Article\Pipes\Update;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Private\News\Article\ArticlePipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\News\ArticleService;
use Carbon\Carbon;
use Closure;

final class ArticlePipe implements PipeInterface
{
    public function __construct(
        private readonly ArticleService $articleService,
    ) {
    }

    public function handle(DtoInterface|ArticlePipelineDto $dto, Closure $next): DtoInterface
    {
        $article = $dto->getArticle();

        $this->articleService->update([
            'uuid' => $article->getUuid(),
        ], [
            'section_uuid' => $article->getSectionUuid(),
            'title' => $article->getTitle(),
            'description' => $article->getDescription(),
            'content' => $article->getContent(),
            'reading_time' => $article->getReadingTime(),
            'slug' => $article->getSlug(),
            'meta_title' => $article->getMetaTitle(),
            'meta_description' => $article->getMetaDescription(),
            'meta_keywords' => $article->getMetaKeywords(),
            'created_at' => Carbon::parse($article->getCreatedAt())->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

        return $next($dto);
    }
}
