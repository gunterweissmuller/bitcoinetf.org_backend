<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\News\Article;

use App\Dto\Pipelines\Api\V1\Private\News\Article\ArticlePipelineDto;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\V1\Private\News\Article\Pipes\ArticleTagPipe;
use App\Pipelines\V1\Private\News\Article\Pipes\Create\ArticleMainFilePipe as CreateArticleMainFilePipe;
use App\Pipelines\V1\Private\News\Article\Pipes\Create\ArticlePipe as CreateArticlePipe;
use App\Pipelines\V1\Private\News\Article\Pipes\Create\ArticlePreviewFilePipe as CreateArticlePreviewFilePipe;
use App\Pipelines\V1\Private\News\Article\Pipes\FilesPipe;
use App\Pipelines\V1\Private\News\Article\Pipes\Update\ArticleMainFilePipe as UpdateArticleMainFilePipe;
use App\Pipelines\V1\Private\News\Article\Pipes\Update\ArticlePipe as UpdateArticlePipe;
use App\Pipelines\V1\Private\News\Article\Pipes\Update\ArticlePreviewFilePipe as UpdateArticlePreviewFilePipe;
use App\Pipelines\V1\Private\Pages\Section\Pipes\Delete\SectionFilePipe as DeleteSectionFilePipe;
use App\Pipelines\V1\Private\Pages\Section\Pipes\Delete\SectionPipe as DeleteSectionPipe;

final class ArticlePipeline extends AbstractPipeline
{
    public function create(ArticlePipelineDto $dto): array
    {
        return $this->pipeline([
            FilesPipe::class,
            CreateArticlePipe::class,
            ArticleTagPipe::class,
            CreateArticlePreviewFilePipe::class,
            CreateArticleMainFilePipe::class,
        ], $dto);
    }

    public function update(ArticlePipelineDto $dto): array
    {
        return $this->pipeline([
            FilesPipe::class,
            UpdateArticlePipe::class,
            ArticleTagPipe::class,
            UpdateArticlePreviewFilePipe::class,
            UpdateArticleMainFilePipe::class,
        ], $dto);
    }

    public function delete(ArticlePipelineDto $dto): array
    {
        return $this->pipeline([
            DeleteSectionPipe::class,
            DeleteSectionFilePipe::class,
        ], $dto);
    }
}
