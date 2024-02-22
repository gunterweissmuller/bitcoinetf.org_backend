<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Dto\Pipelines\Api\V1\Auth\Login\LoginMetamaskPipelineDto;
use App\Http\Requests\Api\V1\Auth\Login\LoginMetamaskRequest;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginPipelineDto;
use App\Http\Requests\Api\V1\Auth\Login\LoginRequest;
use App\Pipelines\V1\Auth\Login\LoginPipeline;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use App\Helpers\EcRecover;

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

    public function loginMetamask(LoginMetamaskRequest $request): JsonResponse
    {
        $walletAddress = Str::lower($request->wallet_address);
        $message   = $request->message;
        $signature = $request->signature;

        $valid = (new EcRecover)->verifySignature($message,  $signature,  $walletAddress);
        if (!$valid) {
            return response()->json(['message' => 'Invalid signature'], 401);
        }

        return response()->json([
            'message' => 'Data processed successfully',
            'is_valid' => $valid, 
            'input' => $request->all(), 
        ], 200);
    }
}
