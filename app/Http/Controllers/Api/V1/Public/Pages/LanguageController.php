<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Pages;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Services\Api\V1\Pages\LanguageService;
use App\Http\Requests\Api\V1\Private\Pages\Language\AllRequest;

final class LanguageController extends Controller
{
    public function __construct(private LanguageService $service) {}

    public function all(AllRequest $request): JsonResponse
    {
        return response()->json($this->service->allByFilters($request->dto()));
    }
}
