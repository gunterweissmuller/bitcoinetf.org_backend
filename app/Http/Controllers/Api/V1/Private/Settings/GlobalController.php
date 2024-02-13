<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Private\Settings;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Dto\Models\Settings\GlobalDto;
use App\Services\Api\V1\Settings\GlobalService;
use App\Http\Requests\Api\V1\Private\Settings\Global\UpdateRequest;

final class GlobalController extends Controller
{
    public function __construct(private GlobalService $globalService)
    {
    }

    public function get(string $symbol): JsonResponse
    {
        return response()->json(['data' => $this->globalService->get(['symbol' => $symbol])?->toArray()]);
    }

    public function all(): JsonResponse
    {
        $rows = $this->globalService->list([]);

        return response()->json([
            'data' => !is_null($rows) ? $rows->map(function (GlobalDto $dto) {
                return $dto->toArray();
            }) : [],
        ]);
    }

    public function update(UpdateRequest $request): JsonResponse
    {
        $dto = $request->dto();

        $this->globalService->update([
            'symbol' => $dto->getSymbol()
        ], [
            'value' => $dto->getValue(),
        ]);

        return response()->json();
    }
}
