<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Billing;

use App\Dto\Models\Billing\TokenDto;
use App\Services\Api\V1\Billing\TokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class TokenController extends Controller
{
    public function __construct(
        private readonly TokenService $tokenService,
    ) {
    }

    public function list(): JsonResponse
    {
        return response()->json([
            'data' => $this->tokenService->all([])->map(function ($dto) {
                return $this->getOutput($dto);
            }),
        ]);
    }

    public function get(string $uuid): JsonResponse
    {
        return response()->json([
            'data' => $this->getOutput($this->tokenService->get(['uuid' => $uuid])),
        ]);
    }

    private function getOutput(TokenDto $dto): array
    {
        return [
            'uuid' => $dto->getUuid(),
            'name' => $dto->getName(),
            'symbol' => $dto->getSymbol(),
            'amount' => $dto->getAmount(),
        ];
    }
}
