<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\News\Article\Pipes\Create;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Private\News\Article\ArticlePipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\News\ArticleService;
use Closure;

final class ArticlePipe implements PipeInterface
{
    public function __construct(
        private readonly ArticleService $articleService,
    ) {
    }

    public function handle(DtoInterface|ArticlePipelineDto $dto, Closure $next): DtoInterface
    {
        $dto->setArticle(
            $this->articleService->create($dto->getArticle()),
        );

        return $next($dto);
    }
}
