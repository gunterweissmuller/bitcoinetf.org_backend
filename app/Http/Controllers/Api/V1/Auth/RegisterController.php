<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitGooglePipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitPipelineDto;
use App\Http\Requests\Api\V1\Auth\Register\ConfirmGoogleRequest;
use App\Http\Requests\Api\V1\Auth\Register\ConfirmRequest;
use App\Http\Requests\Api\V1\Auth\Register\InitGoogleRequest;
use App\Http\Requests\Api\V1\Auth\Register\InitRequest;
use App\Pipelines\V1\Auth\Register\RegisterPipeline;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Symfony\Component\HttpFoundation\Response;

final class RegisterController extends Controller
{
    public function __construct(
        private readonly RegisterPipeline $pipeline,
    ) {
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

    public function redirectUrlToGoogleAuth(): JsonResponse
    {
        return response()->json([
            'url' => Socialite::driver('google')
                ->stateless()
                ->redirect()
                ->getTargetUrl(),
        ]);
    }

    public function initGoogleAuth(InitGoogleRequest $request): JsonResponse
    {
        try {
            /** @var SocialiteUser $socialiteUser */
            $socialiteUser = Socialite::driver('google')->stateless()->user();
        } catch (ClientException $e) {
            return response()->json(['error' => 'Invalid credentials provided.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        /** @var InitGooglePipelineDto $dto */
        [$dto, $e] = $this->pipeline->initGoogleAuth($request->dto());

        if (!$e) {
            return response()->json([
                'data' => [
                    'email' => $dto->getEmail()->getEmail(),
                    'first_name' => ucfirst(strtolower($socialiteUser->offsetGet('given_name'))),
                    'last_name' => ucfirst(strtolower($socialiteUser->offsetGet('family_name'))),
                ]
            ]);
        }

        return response()->__call('exception', [$e]);
    }

    public function confirmGoogleAuth(ConfirmGoogleRequest $request): JsonResponse
    {
        [$dto, $e] = $this->pipeline->confirmGoogleAuth($request->dto());

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
