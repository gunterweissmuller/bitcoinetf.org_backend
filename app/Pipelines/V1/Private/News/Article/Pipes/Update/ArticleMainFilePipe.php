<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\News\Article\Pipes\Update;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Private\News\Article\ArticlePipelineDto;
use App\Enums\News\ArticleFile\TypeEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\News\ArticleFileService;
use Closure;

final class ArticleMainFilePipe implements PipeInterface
{
    public function __construct(
        private readonly ArticleFileService $articleFileService,
    ) {
    }

    public function handle(DtoInterface|ArticlePipelineDto $dto, Closure $next): DtoInterface
    {
        if ($dto->getMainFileUuid()) {
            $this->articleFileService->update([
                'article_uuid' => $dto->getArticle()->getUuid(),
                'type' => TypeEnum::MAIN->value,
            ], [
                'file_uuid' => $dto->getMainFileUuid(),
            ]);
        }

        return $next($dto);
    }
}
