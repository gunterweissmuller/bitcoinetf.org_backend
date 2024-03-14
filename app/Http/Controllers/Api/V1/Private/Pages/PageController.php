<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Private\Pages;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Services\Api\V1\Pages\PageService;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Api\V1\Private\Pages\Page\AllRequest;
use App\Http\Requests\Api\V1\Private\Pages\Page\UpdateRequest;
use App\Http\Requests\Api\V1\Private\Pages\Page\CreateRequest;

final class PageController extends Controller
{
    public function __construct(private PageService $pageService) {}

    public function create(CreateRequest $request): JsonResponse
    {
        return response()->json([
            'data' => $this->pageService->create($request->dto())?->toArray(),
        ], Response::HTTP_CREATED);
    }

    public function get(int $id): JsonResponse
    {
        return response()->json([
            'data' => $this->pageService->get(['id' => $id])?->toArray(),
        ]);
    }

    public function all(AllRequest $request): JsonResponse
    {
        return response()->json($this->pageService->allByFilters($request->dto()));
    }

    public function update(int $id, UpdateRequest $request): JsonResponse
    {
        $dto = $request->dto();
        $dto->setId($id);

        $this->pageService->update(['id' => $id], array_filter($dto->toArray()));

        return response()->json();
    }

    public function delete(int $id): JsonResponse
    {
        $this->pageService->delete(['id' => $id]);

        return response()->json();
    }
}
