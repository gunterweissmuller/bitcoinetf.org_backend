<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Private\News;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Dto\Models\News\IntegrationDto;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Api\V1\News\IntegrationService;
use App\Http\Requests\Api\V1\Private\News\Integration\UpdateRequest;
use App\Http\Requests\Api\V1\Private\News\Integration\CreateRequest;

final class IntegrationController extends Controller
{
    public function __construct(private IntegrationService $service) {}

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

    public function list(): JsonResponse
    {
        return response()->json([
            'data' => $this->service->all([])?->map(function (IntegrationDto $integration) {
                return $integration->toArray();
            }),
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
