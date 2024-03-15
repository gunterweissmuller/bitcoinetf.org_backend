<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Private\News;

use App\Dto\Pipelines\Api\V1\Private\News\Article\ArticlePipelineDto;
use App\Enums\News\ArticleFile\TypeEnum;
use App\Http\Requests\Api\V1\Private\News\Article\CreateRequest;
use App\Http\Requests\Api\V1\Private\News\Article\ListRequest;
use App\Http\Requests\Api\V1\Private\News\Article\UpdateRequest;
use App\Pipelines\V1\Private\News\Article\ArticlePipeline;
use App\Services\Api\V1\News\ArticleFileService;
use App\Services\Api\V1\News\ArticleService;
use App\Services\Api\V1\News\ArticleTagService;
use App\Services\Api\V1\News\TagService;
use App\Services\Api\V1\Storage\FileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

final class ArticleController extends Controller
{
    public function __construct(
        private readonly ArticleService $service,
        private readonly ArticlePipeline $pipeline,
        private readonly ArticleTagService $articleTagService,
        private readonly ArticleFileService $articleFileService,
        private readonly TagService $tagService,
        private readonly FileService $fileService,
    ) {
    }

    public function create(CreateRequest $request): JsonResponse
    {
        /** @var ArticlePipelineDto $dto */
        [$dto, $e] = $this->pipeline->create($request->dto());

        if (!$e) {
            return response()->json([
                'data' => $dto->getArticle()->toArray(),
            ], Response::HTTP_CREATED);
        }

        return response()->__call('exception', [$e]);
    }

    public function get(string $uuid): JsonResponse
    {
        if ($previewFile = $this->articleFileService->get([
            'article_uuid' => $uuid,
            'type' => TypeEnum::PREVIEW->value,
        ])) {
            $previewFile = $this->fileService->get([
                'uuid' => $previewFile->getFileUuid(),
            ]);

            $previewFile = $previewFile ? [
                'uuid' => $previewFile->getUuid(),
                'path' => $previewFile->getPath(),
            ] : null;
        }

        if ($mainFile = $this->articleFileService->get([
            'article_uuid' => $uuid,
            'type' => TypeEnum::MAIN->value,
        ])) {
            $mainFile = $this->fileService->get([
                'uuid' => $mainFile->getFileUuid(),
            ]);

            $mainFile = $mainFile ? [
                'uuid' => $mainFile->getUuid(),
                'path' => $mainFile->getPath(),
            ] : null;
        }

        return response()->json([
            'data' => [
                ...$this->service->get(['uuid' => $uuid])?->toArray(),
                'tags' => $this->tagService->all([], function ($query) use ($uuid) {
                    $uuids = $this->articleTagService->getTagUuidsByArticleUuid($uuid);
                    return $query->whereIn('uuid', $uuids?->toArray());
                })?->map(function ($row) {
                    return [
                        'uuid' => $row->getUuid(),
                        'title' => $row->getTitle(),
                    ];
                }),
                'preview_file' => $previewFile ?? null,
                'main_file' => $mainFile ?? null,
            ],
        ]);
    }

    public function list(ListRequest $request): JsonResponse
    {
        return response()->json([
            'data' => $this->service->allByFilters($request->dto()),
        ]);
    }

    public function update(string $uuid, UpdateRequest $request): JsonResponse
    {
        $dto = $request->dto();
        $dto->getArticle()->setUuid($uuid);

        /** @var ArticlePipelineDto $dto */
        [$dto, $e] = $this->pipeline->update($dto);

        if (!$e) {
            return response()->json();
        }

        return response()->__call('exception', [$e]);
    }

    public function delete(string $uuid): JsonResponse
    {
        $this->service->delete(['uuid' => $uuid]);

        return response()->json();
    }
}
