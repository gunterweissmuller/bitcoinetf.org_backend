<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Private\Referrals;

use App\Http\Requests\Api\V1\Private\Referrals\Code\AllRequest;
use App\Http\Requests\Api\V1\Private\Referrals\Code\UpdateRequest;
use App\Services\Api\V1\Referrals\CodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class CodeController extends Controller
{
    public function __construct(
        private readonly CodeService $service,
    ) {
    }

    public function all(AllRequest $request): JsonResponse
    {
        return response()->json([
            'data' => $this->service->allByFilters($request->dto()),
        ]);
    }

    public function get(string $uuid): JsonResponse
    {
        return response()->json([
            'data' => $this->service->get(['uuid' => $uuid])?->toArray(),
        ]);
    }

    public function update(UpdateRequest $request, string $uuid): JsonResponse
    {
        if ($code = $this->service->get(['uuid' => $uuid])) {
            $this->service->update([
                'uuid' => $code->getUuid(),
            ], array_filter($request->dto()->toArray()));
        }

        return response()->json();
    }
}
