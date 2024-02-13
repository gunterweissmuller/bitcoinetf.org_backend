<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Private\Kyc;

use App\Dto\Models\Kyc\SessionResultDto;
use App\Http\Requests\Api\V1\Private\Kyc\SessionResult\ListRequest;
use App\Http\Requests\Api\V1\Private\Kyc\SessionResult\UpdateRequest;
use App\Services\Api\V1\Kyc\SessionResultService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class SessionResultController extends Controller
{
    public function __construct(
        private readonly SessionResultService $service,
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
        $dto = $request->dto();

        return response()->json([
            'data' => $this->service->all(array_filter($dto->toArray()))?->map(function (SessionResultDto $row) {
                return $row->toArray();
            }),
        ]);
    }

    public function delete(string $uuid): JsonResponse
    {
        $this->service->delete(['uuid' => $uuid]);

        return response()->json();
    }
}
