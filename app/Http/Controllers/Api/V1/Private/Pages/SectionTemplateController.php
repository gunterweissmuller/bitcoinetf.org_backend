<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Private\Pages;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Dto\Models\Pages\SectionTemplateDto;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Api\V1\Pages\SectionTemplateService;
use App\Pipelines\V1\Private\Pages\SectionTemplate\SectionPipeline;
use App\Http\Requests\Api\V1\Private\Pages\SectionTemplate\UpdateRequest;
use App\Http\Requests\Api\V1\Private\Pages\SectionTemplate\CreateRequest;
use App\Dto\Pipelines\Api\V1\Private\Pages\Section\SectionTemplatePipelineDto;

final class SectionTemplateController extends Controller
{
    public function __construct(
        private SectionPipeline $pipeline,
        private SectionTemplateService  $service
    ) {}

    public function create(CreateRequest $request): JsonResponse
    {
        $dto = $request->dto();
        /** @var SectionTemplatePipelineDto $dto */
        [$dto, $e] = $this->pipeline->create($dto);

        if (!$e) {
            return response()->json([
                'data' => $this->service->get(['id' => $dto->getSectionTemplate()->getId()])?->toArray(),
            ], Response::HTTP_CREATED);
        }

        return response()->__call('exception', [$e]);
    }

    public function update(int $id, UpdateRequest $request): JsonResponse
    {
        $dto = $request->dto();
        $dto->getSectionTemplate()->setId($id);

        [$dto, $e] = $this->pipeline->update($dto);

        if (!$e) {
            return response()->json();
        }

        return response()->__call('exception', [$e]);
    }

    public function get(int $id): JsonResponse
    {
        return response()->json(['data' => $this->service->get(['id' => $id])?->toArray()]);
    }

    public function all(): JsonResponse
    {
        $rows = $this->service->list([]);

        return response()->json([
            'data' => !is_null($rows) ? $rows->map(function (SectionTemplateDto $section) {
                return $section->toArray();
            }) : null,
        ]);
    }

    public function delete(int $id): JsonResponse
    {
        [$dto, $e] = $this->pipeline->delete(SectionTemplatePipelineDto::fromArray([
            'section_template' => SectionTemplateDto::fromArray(['id' => $id]),
        ]));

        if (!$e) {
            return response()->json();
        }

        return response()->__call('exception', [$e]);
    }
}
