<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\News\Article\Pipes;

use App\Dto\DtoInterface;
use App\Dto\Models\News\ArticleTagDto;
use App\Dto\Pipelines\Api\V1\Private\News\Article\ArticlePipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\News\ArticleTagService;
use Closure;

final class ArticleTagPipe implements PipeInterface
{
    public function __construct(
        private readonly ArticleTagService $articleTagService,
    ) {
    }

    public function handle(DtoInterface|ArticlePipelineDto $dto, Closure $next): DtoInterface
    {
        $article = $dto->getArticle();
        $tagUuids = $dto->getTagUuids();

        $this->articleTagService->delete(['article_uuid' => $article->getUuid()]);
        
        foreach ($tagUuids as $tagUuid) {
            $this->articleTagService->create(ArticleTagDto::fromArray([
                'article_uuid' => $article->getUuid(),
                'tag_uuid' => $tagUuid,
            ]));
        }

        return $next($dto);
    }
}
