<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\News\Article\Pipes\Create;

use App\Dto\DtoInterface;
use App\Dto\Models\News\ArticleFileDto;
use App\Dto\Pipelines\Api\V1\Private\News\Article\ArticlePipelineDto;
use App\Enums\News\ArticleFile\TypeEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\News\ArticleFileService;
use Closure;

final class ArticlePreviewFilePipe implements PipeInterface
{
    public function __construct(
        private readonly ArticleFileService $articleFileService,
    ) {
    }

    public function handle(DtoInterface|ArticlePipelineDto $dto, Closure $next): DtoInterface
    {
        $this->articleFileService->create(ArticleFileDto::fromArray([
            'article_uuid' => $dto->getArticle()->getUuid(),
            'file_uuid' => $dto->getPreviewFileUuid(),
            'type' => TypeEnum::PREVIEW->value,
        ]));

        return $next($dto);
    }
}
