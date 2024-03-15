<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\News;

use App\Http\Requests\Api\V1\Public\News\Section\ListRequest;
use App\Services\Api\V1\News\SectionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class SectionController extends Controller
{
    public function __construct(
        private readonly SectionService $service
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
                'title' => $row['title'],
                'slug' => $row['slug'],
            ];
        });

        return response()->json([
            'data' => $rows,
        ]);
    }
}
