<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Dto\Pipelines\Api\V1\Auth\Login\LoginPipelineDto;
use App\Http\Requests\Api\V1\Auth\Login\LoginRequest;
use App\Pipelines\V1\Auth\Login\LoginPipeline;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class LoginController extends Controller
{
    public function __construct(
        private readonly LoginPipeline $pipeline,
    ) {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        /** @var LoginPipelineDto $dto */
        [$dto, $e] = $this->pipeline->login($request->dto());

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
