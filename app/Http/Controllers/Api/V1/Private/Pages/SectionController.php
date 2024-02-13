<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Private\Pages;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Dto\Models\Pages\SectionDto;
use App\Services\Api\V1\Pages\SectionService;
use Symfony\Component\HttpFoundation\Response;
use App\Pipelines\V1\Private\Pages\Section\SectionPipeline;
use App\Http\Requests\Api\V1\Private\Pages\Section\AllRequest;
use App\Http\Requests\Api\V1\Private\Pages\Section\UpdateRequest;
use App\Http\Requests\Api\V1\Private\Pages\Section\CreateRequest;
use App\Dto\Pipelines\Api\V1\Private\Pages\Section\SectionPipelineDto;

final class SectionController extends Controller
{
    public function __construct(
        private SectionPipeline $pipeline,
        private SectionService  $service
    ) {}

    public function create(int $pageId, CreateRequest $request): JsonResponse
    {
        $dto = $request->dto();
        $dto->getSection()->setPageId($pageId);
        /** @var SectionPipelineDto $dto */
        [$dto, $e] = $this->pipeline->create($dto);

        if (!$e) {
            return response()->json([
                'data' => $this->service->get(['id' => $dto->getSection()->getId()])?->toArray(),
            ], Response::HTTP_CREATED);
        }

        return response()->__call('exception', [$e]);
    }

    public function update(int $pageId, int $sectionId, UpdateRequest $request): JsonResponse
    {
        $dto = $request->dto();
        $dto->getSection()->setId($sectionId);
        $dto->getSection()->setPageId($pageId);

        [$dto, $e] = $this->pipeline->update($dto);

        if (!$e) {
            return response()->json();
        }

        return response()->__call('exception', [$e]);
    }

    public function get(int $pageId, int $sectionId): JsonResponse
    {
        return response()->json([
            'data' => $this->service->get([
                'page_id' => $pageId,
                'id' => $sectionId
            ])?->toArray(),
        ]);
    }

    public function all(int $id, AllRequest $request): JsonResponse
    {
        $rows = $this->service->list([
            'page_id' => $id,
            'language_id' => $request->dto()->getLanguageId(),
        ]);

        return response()->json([
            'data' => !is_null($rows) ? $rows->map(function (SectionDto $section) {
                return $section->toArray();
            }) : null,
        ]);
    }

    public function delete(int $pageId, int $sectionId): JsonResponse
    {
        [$dto, $e] = $this->pipeline->delete(SectionPipelineDto::fromArray([
            'section' => SectionDto::fromArray(['page_id' => $pageId, 'id' => $sectionId]),
        ]));

        if (!$e) {
            return response()->json();
        }

        return response()->__call('exception', [$e]);
    }
}
