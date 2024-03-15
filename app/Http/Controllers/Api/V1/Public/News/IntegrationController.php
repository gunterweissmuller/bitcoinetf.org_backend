<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\News;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Dto\Models\News\IntegrationDto;
use App\Enums\News\Integration\StatusEnum;
use App\Services\Api\V1\News\IntegrationService;

final class IntegrationController extends Controller
{
    public function list(IntegrationService $service): JsonResponse
    {
        return response()->json([
            'data' => $service->all([
                'status' => StatusEnum::ACTIVE->value,
            ])?->map(function (IntegrationDto $integration) {
                return [
                    'uuid' => $integration->getUuid(),
                    'public_key' => $integration->getPublicKey(),
                    'private_key' => $integration->getPrivateKey(),
                    'link' => $integration->getLink()
                ];
            }),
        ]);
    }
}
