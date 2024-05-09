<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\News;

use App\Enums\News\ArticleFile\TypeEnum;
use App\Exceptions\Core\NotFoundException;
use App\Http\Requests\Api\V1\Public\News\Article\GetRequest;
use App\Http\Requests\Api\V1\Public\News\Article\ListRequest;
use App\Services\Api\V1\News\ArticleFileService;
use App\Services\Api\V1\News\ArticleService;
use App\Services\Api\V1\News\ArticleTagService;
use App\Services\Api\V1\News\SectionService;
use App\Services\Api\V1\News\TagService;
use App\Services\Api\V1\Storage\FileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class ArticleController extends Controller
{
    public function __construct(
        private readonly ArticleService $service,
        private readonly SectionService $sectionService,
        private readonly ArticleTagService $articleTagService,
        private readonly ArticleFileService $articleFileService,
        private readonly TagService $tagService,
        private readonly FileService $fileService,
    ) {
    }

    public function get(GetRequest $request): JsonResponse
    {
        $dto = $request->dto();

        $article = null;
        if ($dto->getUuid()) {
            $article = $this->service->get(['uuid' => $dto->getUuid()]);
        } else {
            $section = $this->sectionService->get(['slug' => $dto->getSectionSlug()]);

            if ($section) {
                $article = $this->service->get([
                    'slug' => $dto->getArticleSlug(),
                    'section_uuid' => $section->getUuid(),
                ]);
            }
        }

        if (is_null($article)) {
            throw new NotFoundException();
        }

        if ($previewFile = $this->articleFileService->get([
            'article_uuid' => $article->getUuid(),
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
            'article_uuid' => $article->getUuid(),
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
                ...$article->toArray(),
                'tags' => $this->tagService->all([], function ($query) use ($article) {
                    $uuids = $this->articleTagService->getTagUuidsByArticleUuid($article->getUuid());
                    return $uuids ? $query->whereIn('uuid', $uuids?->toArray()) : $query;
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
        $dto = $request->dto();
        $filters = $dto->getFilters();

        $articleUuids = [];
        if ($tagUuids = $filters['tag_uuids'] ?? null) {
            foreach ($tagUuids as $tagUuid) {
                $articleUuids = array_merge(
                    $articleUuids,
                    $this->articleTagService->getArticleUuidsByTagUuid($tagUuid)?->toArray()
                );
            }
        }

        if (array_key_exists('tag_uuids', $filters)) {
            $filters['uuid'] = $filters['tag_uuids'];
            unset($filters['tag_uuids']);
        }
        $dto->setFilters($filters);

        $rows = $this->service->allByFilters($dto, function ($query) use ($articleUuids) {
            return $articleUuids ? $query->whereIn('uuid', array_unique($articleUuids)) : $query;
        });

        $rows->getCollection()->transform(function ($row) {
            if ($previewFile = $this->articleFileService->get([
                'article_uuid' => $row['uuid'],
                'type' => TypeEnum::PREVIEW->value,
            ])) {
                $previewFile = $this->fileService->get([
                    'uuid' => $previewFile->getFileUuid(),
                ]);

                $previewFilePath = $previewFile?->getPath();
            }

            return [
                'uuid' => $row['uuid'],
                'section_uuid' => $row['section_uuid'],
                'title' => $row['title'],
                'description' => $row['description'],
                'reading_time' => $row['reading_time'],
                'slug' => $row['slug'],
                'created_at' => $row['created_at'],
                'preview_file' => $previewFilePath ?? null,
                'tags' => $this->tagService->all([], function ($query) use ($row) {
                    $uuids = $this->articleTagService->getTagUuidsByArticleUuid($row['uuid']);
                    return $uuids ? $query->whereIn('uuid', $uuids?->toArray()) : $query;
                })?->map(function ($row) {
                    return $row->getTitle();
                }),
            ];
        });

        return response()->json([
            'data' => $rows,
        ]);
    }
}
