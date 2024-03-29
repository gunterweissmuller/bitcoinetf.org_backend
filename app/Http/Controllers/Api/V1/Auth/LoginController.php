<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Dto\Pipelines\Api\V1\Auth\Login\LoginFacebookPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginTelegramPipelineDto;
use App\Exceptions\Pipelines\V1\Auth\AuthorizationTokenExpiredException;
use App\Exceptions\Pipelines\V1\Auth\InvalidSignatureMetamaskException;
use App\Http\Requests\Api\V1\Auth\Login\LoginAppleRequest;
use App\Http\Requests\Api\V1\Auth\Login\LoginFacebookRequest;
use App\Http\Requests\Api\V1\Auth\Login\LoginMetamaskRequest;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginPipelineDto;
use App\Http\Requests\Api\V1\Auth\Login\LoginRequest;
use App\Http\Requests\Api\V1\Auth\Login\LoginTelegramRequest;
use App\Pipelines\V1\Auth\Login\LoginPipeline;
use App\Services\Utils\AppleAuthJWTService;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use App\Helpers\EcRecover;
use Laravel\Socialite\Facades\Socialite;

final class LoginController extends Controller
{
    public function __construct(
        private readonly LoginPipeline $pipeline,
    )
    {
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
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

    /**
     * @param LoginMetamaskRequest $request
     * @return JsonResponse
     */
    public function loginMetamask(LoginMetamaskRequest $request): JsonResponse
    {
        $walletAddress = Str::lower($request->wallet_address);
        $message = $request->message;
        $signature = $request->signature;

        $valid = (new EcRecover)->verifySignature($message, $signature, $walletAddress);
        if (!$valid || $message !== METAMASK_MSG) {
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

    /**
     * @param LoginAppleRequest $request
     * @return JsonResponse
     */
    public function loginApple(LoginAppleRequest $request): JsonResponse
    {
        try {
            config()->set('services.apple.client_secret', AppleAuthJWTService::getInstance()->getSecretKey());
            Socialite::driver('apple')->stateless()->userByIdentityToken($request->apple_token);
        } catch (ClientException $e) {
            return response()->__call('exception', [new AuthorizationTokenExpiredException]);
        }

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

    /**
     * @param LoginTelegramRequest $request
     * @return JsonResponse
     */
    public function loginTelegram(LoginTelegramRequest $request): JsonResponse
    {
        /** @var LoginTelegramPipelineDto $dto */
        [$dto, $e] = $this->pipeline->loginTelegram($request->dto());

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

    /**
     * @param LoginFacebookRequest $request
     * @return JsonResponse
     */
    public function loginFacebook(LoginFacebookRequest $request): JsonResponse
    {
        /** @var LoginFacebookPipelineDto $dto */
        [$dto, $e] = $this->pipeline->loginFacebook($request->dto());

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
