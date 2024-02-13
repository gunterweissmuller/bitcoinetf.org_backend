<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Private\Kyc;

use App\Dto\Models\Kyc\FormDto;
use App\Http\Requests\Api\V1\Private\Kyc\Form\CreateRequest;
use App\Http\Requests\Api\V1\Private\Kyc\Form\UpdateRequest;
use App\Services\Api\V1\Kyc\FormService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

final class FormController extends Controller
{
    public function __construct(
        private readonly FormService $service,
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

    public function list(): JsonResponse
    {
        return response()->json([
            'data' => $this->service->all([])?->map(function (FormDto $row) {
                return $row->toArray();
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
