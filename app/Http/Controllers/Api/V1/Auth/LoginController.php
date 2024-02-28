<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Exceptions\Pipelines\V1\Auth\InvalidSignatureMetamaskException;
use App\Http\Requests\Api\V1\Auth\Login\LoginAppleRequest;
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
            return response()->__call('exception', [new InvalidSignatureMetamaskException]);
        }

        [$dto, $e] = $this->pipeline->loginMetamask($request->dto());

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

    public function loginApple(LoginAppleRequest $request): JsonResponse
    {
        //@fixme-v
//        try {
//            /** @var SocialiteUser $socialiteUser */
//            $socialiteUser = Socialite::driver('sign-in-with-apple')->stateless()->user();
//        } catch (ClientException $e) {
//            return response()->__call('exception', [new AuthorizationTokenExpiredException]);
//        }

        [$dto, $e] = $this->pipeline->loginApple($request->dto());

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
