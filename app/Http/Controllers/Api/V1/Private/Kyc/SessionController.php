<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Private\Kyc;

use App\Dto\Models\Kyc\SessionDto;
use App\Http\Requests\Api\V1\Private\Kyc\Session\ListRequest;
use App\Services\Api\V1\Kyc\SessionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class SessionController extends Controller
{
    public function __construct(
        private readonly SessionService $service,
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
            'data' => $this->service->all(array_filter($dto->toArray()))?->map(function (SessionDto $row) {
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
