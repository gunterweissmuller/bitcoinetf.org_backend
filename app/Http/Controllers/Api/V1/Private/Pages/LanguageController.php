<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Private\Pages;

use App\Http\Requests\Api\V1\Private\Pages\Language\AllRequest;
use App\Http\Requests\Api\V1\Private\Pages\Language\CreateRequest;
use App\Http\Requests\Api\V1\Private\Pages\Language\UpdateRequest;
use App\Services\Api\V1\Pages\LanguageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

final class LanguageController extends Controller
{
    public function __construct(
        private readonly LanguageService $service
    ) {
    }

    public function create(CreateRequest $request): JsonResponse
    {
        return response()->json([
            'data' => $this->service->create($request->dto())?->toArray(),
        ], Response::HTTP_CREATED);
    }

    public function get(int $id): JsonResponse
    {
        return response()->json([
            'data' => $this->service->get(['id' => $id])?->toArray(),
        ]);
    }

    public function all(AllRequest $request): JsonResponse
    {
        return response()->json($this->service->allByFilters($request->dto()));
    }

    public function update(int $id, UpdateRequest $request): JsonResponse
    {
        $dto = $request->dto();
        $dto->setId($id);

        $this->service->update(['id' => $id], array_filter($dto->toArray()));

        return response()->json();
    }

    public function delete(int $id): JsonResponse
    {
        $this->service->delete(['id' => $id]);

        return response()->json();
    }
}
