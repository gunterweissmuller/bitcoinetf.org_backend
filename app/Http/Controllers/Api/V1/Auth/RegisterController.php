<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmFacebookPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmTelegramPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitFacebookPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitTelegramPipelineDto;
use App\Exceptions\Pipelines\V1\Auth\AuthorizationTokenExpiredException;
use App\Exceptions\Pipelines\V1\Auth\InvalidSignatureMetamaskException;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmApplePipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitPipelineDto;
use App\Http\Requests\Api\V1\Auth\Register\ConfirmAppleRequest;
use App\Http\Requests\Api\V1\Auth\Register\ConfirmFacebookRequest;
use App\Http\Requests\Api\V1\Auth\Register\ConfirmRequest;
use App\Http\Requests\Api\V1\Auth\Register\InitAppleRequest;
use App\Http\Requests\Api\V1\Auth\Register\ConfirmTelegramRequest;
use App\Http\Requests\Api\V1\Auth\Register\InitFacebookRequest;
use App\Http\Requests\Api\V1\Auth\Register\InitRequest;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmMetamaskPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitMetamaskPipelineDto;
use App\Http\Requests\Api\V1\Auth\Register\ConfirmMetamaskRequest;
use App\Http\Requests\Api\V1\Auth\Register\InitMetamaskRequest;
use App\Http\Requests\Api\V1\Auth\Register\InitTelegramRequest;
use App\Pipelines\V1\Auth\Register\RegisterPipeline;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use App\Helpers\EcRecover;
use Laravel\Socialite\Facades\Socialite;

final class RegisterController extends Controller
{
    public function __construct(
        private readonly RegisterPipeline $pipeline,
    )
    {
    }

    public function init(InitRequest $request): JsonResponse
    {
        /** @var InitPipelineDto $dto */
        [$dto, $e] = $this->pipeline->init($request->dto());

        if (!$e) {
            return response()->json();
        }

        return response()->__call('exception', [$e]);
    }

    public function confirm(ConfirmRequest $request): JsonResponse
    {
        /** @var ConfirmPipelineDto $dto */
        [$dto, $e] = $this->pipeline->confirm($request->dto());

        if (!$e) {
            return response()->json([
                'data' => [
                    'access_token' => $dto->getJwtAccess()->getToken(),
                    'refresh_token' => $dto->getJwtRefresh()->getToken(),
                    'websocket_token' => $dto->getWebsocketToken(),
                    'bonus' => $dto->getBonus(),
                ]
            ]);
        }

        return response()->__call('exception', [$e]);
    }

    public function metamaskMessage(): JsonResponse
    {
        return response()->json([
            'message' => METAMASK_MSG
        ], 200);
    }

    public function metamaskInit(InitMetamaskRequest $request): JsonResponse
    {
        $walletAddress = Str::lower($request->wallet_address);
        $message = $request->message;
        $signature = $request->signature;

        $valid = (new EcRecover)->verifySignature($message, $signature, $walletAddress);
        if (!$valid || $message !== METAMASK_MSG) {
            return response()->__call('exception', [new InvalidSignatureMetamaskException]);
        }

        /** @var InitMetamaskPipelineDto $dto */
        [$dto, $e] = $this->pipeline->initMetamaskAuth($request->dto());

        if (!$e) {
            return response()->json();
        }

        return response()->__call('exception', [$e]);

    }

    public function metamaskConfirm(ConfirmMetamaskRequest $request): JsonResponse
    {
        /** @var ConfirmMetamaskPipelineDto $dto */
        [$dto, $e] = $this->pipeline->confirmMetamaskAuth($request->dto());

        if (!$e) {
            return response()->json([
                'data' => [
                    'access_token' => $dto->getJwtAccess()->getToken(),
                    'refresh_token' => $dto->getJwtRefresh()->getToken(),
                    'websocket_token' => $dto->getWebsocketToken(),
                    'bonus' => $dto->getBonus(),
                ]
            ]);
        }

        return response()->__call('exception', [$e]);
    }

    /**
     * @return JsonResponse
     */
    public function redirectUrlToAppleAuth(): JsonResponse
    {
        return response()->json([
            'url' => Socialite::driver('apple')
                ->stateless()
                ->redirect()
                ->getTargetUrl(),
        ]);
    }

    /**
     * @param InitAppleRequest $request
     * @return JsonResponse
     */
    public function initApple(InitAppleRequest $request): JsonResponse
    {
        try {
            Socialite::driver('apple')->stateless()->userByIdentityToken($request->apple_token);
        } catch (ClientException $e) {
            return response()->__call('exception', [new AuthorizationTokenExpiredException]);
        }

        /** @var InitAppleRequest $dto */
        [$dto, $e] = $this->pipeline->initAppleAuth($request->dto());

        if (!$e) {
            return response()->json();
        }

        return response()->__call('exception', [$e]);
    }

    /**
     * @param ConfirmAppleRequest $request
     * @return JsonResponse
     */
    public function confirmApple(ConfirmAppleRequest $request): JsonResponse
    {
        try {
            Socialite::driver('apple')->stateless()->userByIdentityToken($request->apple_token);
        } catch (ClientException $e) {
            return response()->__call('exception', [new AuthorizationTokenExpiredException]);
        }

        /** @var ConfirmApplePipelineDto $dto */
        [$dto, $e] = $this->pipeline->confirmAppleAuth($request->dto());

        if (!$e) {
            return response()->json([
                'data' => [
                    'access_token' => $dto->getJwtAccess()->getToken(),
                    'refresh_token' => $dto->getJwtRefresh()->getToken(),
                    'websocket_token' => $dto->getWebsocketToken(),
                    'bonus' => $dto->getBonus(),
                ]
            ]);
        }

        return response()->__call('exception', [$e]);
    }

    /**
     * @return JsonResponse
     */
    public function getCredentialsTelegram(): JsonResponse
    {
        return response()->json([
            'data' => [
                'bot_name' => env('TELEGRAM_BOT_NAME'),
                'redirect_url' => env('TELEGRAM_REDIRECT_URI'),
                'bot_id' => explode(':', env('TELEGRAM_CLIENT_SECRET'))[0],
            ]
        ]);
    }

    /**
     * @param InitTelegramRequest $request
     * @return JsonResponse
     */
    public function initTelegram(InitTelegramRequest $request): JsonResponse
    {
        /** @var InitTelegramPipelineDto $dto */
        [$dto, $e] = $this->pipeline->initTelegramAuth($request->dto());

        if (!$e) {
            return response()->json();
        }

        return response()->__call('exception', [$e]);
    }

    /**
     * @param ConfirmTelegramRequest $request
     * @return JsonResponse
     */
    public function confirmTelegram(ConfirmTelegramRequest $request): JsonResponse
    {
        /** @var ConfirmTelegramPipelineDto $dto */
        [$dto, $e] = $this->pipeline->confirmTelegramAuth($request->dto());

        if (!$e) {
            return response()->json([
                'data' => [
                    'access_token' => $dto->getJwtAccess()->getToken(),
                    'refresh_token' => $dto->getJwtRefresh()->getToken(),
                    'websocket_token' => $dto->getWebsocketToken(),
                    'bonus' => $dto->getBonus(),
                ]
            ]);
        }

        return response()->__call('exception', [$e]);
    }

    /**
     * @return JsonResponse
     */
    public function getCredentialsFacebook(): JsonResponse
    {
        return response()->json([
            'data' => [
                'client_id' => env('FACEBOOK_CLIENT_ID'),
                'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
                'redirect_uri' => env('FACEBOOK_REDIRECT_URI'),
            ]
        ]);
    }

    /**
     * @param InitFacebookRequest $request
     * @return JsonResponse
     */
    public function initFacebook(InitFacebookRequest $request): JsonResponse
    {
        /** @var InitFacebookPipelineDto $dto */
        [$dto, $e] = $this->pipeline->initFacebookAuth($request->dto());

        if (!$e) {
            return response()->json();
        }

        return response()->__call('exception', [$e]);
    }

    /**
     * @param ConfirmFacebookRequest $request
     * @return JsonResponse
     */
    public function confirmFacebook(ConfirmFacebookRequest $request): JsonResponse
    {
        /** @var ConfirmFacebookPipelineDto $dto */
        [$dto, $e] = $this->pipeline->confirmFacebookAuth($request->dto());

        if (!$e) {
            return response()->json([
                'data' => [
                    'access_token' => $dto->getJwtAccess()->getToken(),
                    'refresh_token' => $dto->getJwtRefresh()->getToken(),
                    'websocket_token' => $dto->getWebsocketToken(),
                    'bonus' => $dto->getBonus(),
                ]
            ]);
        }

        return response()->__call('exception', [$e]);
    }
}
