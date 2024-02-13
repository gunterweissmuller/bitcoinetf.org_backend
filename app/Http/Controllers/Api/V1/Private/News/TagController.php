<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Private\News;

use App\Http\Requests\Api\V1\Private\News\Tag\CreateRequest;
use App\Http\Requests\Api\V1\Private\News\Tag\ListRequest;
use App\Http\Requests\Api\V1\Private\News\Tag\UpdateRequest;
use App\Services\Api\V1\News\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

final class TagController extends Controller
{
    public function __construct(
        private readonly TagService $service,
    ) {
    }

    public function create(CreateRequest $request): JsonResponse
    {
        return response()->json([
            'data' => $this->service->create($request->dto())?->toArray(),
        ], Response::HTTP_CREATED);
    }

    public function get(string $uuid): JsonResponse
    {
        return response()->json([
            'data' => $this->service->get(['uuid' => $uuid])?->toArray(),
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
        $dto->setUuid($uuid);

        $this->service->update(['uuid' => $uuid], array_filter($dto->toArray()));

        return response()->json();
    }

    public function delete(string $uuid): JsonResponse
    {
        $this->service->delete(['uuid' => $uuid]);

        return response()->json();
    }
}
