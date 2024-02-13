<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\News;

use App\Http\Requests\Api\V1\Public\News\Tag\ListRequest;
use App\Services\Api\V1\News\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class TagController extends Controller
{
    public function __construct(
        private readonly TagService $service
    ) {
    }

    public function get(string $uuid): JsonResponse
    {
        return response()->json([
            'data' => $this->service->get(['uuid' => $uuid])?->toArray(),
        ]);
    }

    public function list(ListRequest $request): JsonResponse
    {
        $rows = $this->service->allByFilters($request->dto());

        $rows->getCollection()->transform(function ($row) {
            return [
                'uuid' => $row['uuid'],
                'section_uuid' => $row['section_uuid'],
                'title' => $row['title'],
            ];
        });

        return response()->json([
            'data' => $rows,
        ]);
    }
}
