<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Private\Users;

use App\Http\Requests\Api\V1\Private\Users\Email\AllRequest;
use App\Http\Requests\Api\V1\Private\Users\Email\UpdateRequest;
use App\Services\Api\V1\Users\EmailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class EmailController extends Controller
{
    public function __construct(
        private readonly EmailService $service,
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
        $this->service->update([
            'uuid' => $uuid,
        ], array_filter($request->dto()->toArray()));
        
        return response()->json();
    }
}
