<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Dto\Pipelines\Api\V1\Auth\Token\RefreshPipelineDto;
use App\Http\Requests\Api\V1\Auth\Token\RefreshRequest;
use App\Pipelines\V1\Auth\Token\TokenPipeline;
use Illuminate\Http\JsonResponse;

final class TokenController
{
    public function __construct(
        private readonly TokenPipeline $pipeline,
    ) {
    }

    public function refresh(RefreshRequest $request): JsonResponse
    {
        /** @var RefreshPipelineDto $dto */
        [$dto, $e] = $this->pipeline->refresh($request->dto());

        if (!$e) {
            return response()->json([
                'data' => [
                    'access_token' => $dto->getJwtAccess()->getToken(),
                    'refresh_token' => $dto->getJwtRefresh()->getToken(),
                    'websocket_token' => $dto->getWebsocketToken(),
                ]
            ]);
        }

        return response()->__call('exception', [$e]);
    }
}
