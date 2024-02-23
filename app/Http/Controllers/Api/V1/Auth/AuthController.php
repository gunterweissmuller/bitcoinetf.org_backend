<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Dto\Pipelines\Api\V1\Auth\Login\LoginGooglePipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitApplePipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitGooglePipelineDto;
use App\Enums\Users\Email\StatusEnum as EmailStatusEnum;
use App\Exceptions\Pipelines\V1\Auth\AuthorizationTokenExpiredException;
use App\Http\Requests\Api\V1\Auth\Login\LoginGoogleRequest;
use App\Http\Requests\Api\V1\Auth\Register\ConfirmGoogleRequest;
use App\Http\Requests\Api\V1\Auth\Register\InitAppleRequest;
use App\Http\Requests\Api\V1\Auth\Register\InitGoogleRequest;
use App\Pipelines\V1\Auth\Login\LoginPipeline;
use App\Pipelines\V1\Auth\Register\RegisterPipeline;
use App\Services\Api\V1\Users\AccountService;
use App\Services\Api\V1\Users\EmailService;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;

final class AuthController extends Controller
{
    public function __construct(
        private readonly LoginPipeline    $loginPipeline,
        private readonly RegisterPipeline $registerPipeline,
        private readonly EmailService     $emailService,
        private readonly AccountService   $accountService,
    )
    {
    }

    /**
     * @return JsonResponse
     */
    public function redirectUrlToGoogleAuth(): JsonResponse
    {
        return response()->json([
            'url' => Socialite::driver('google')
                ->stateless()
                ->redirect()
                ->getTargetUrl(),
        ]);
    }

    /**
     * @param InitGoogleRequest $request
     * @return JsonResponse
     */
    public function initGoogleAuth(InitGoogleRequest $request): JsonResponse
    {
        try {
            /** @var SocialiteUser $socialiteUser */
            $socialiteUser = Socialite::driver('google')->stateless()->user();
        } catch (ClientException $e) {
            return response()->__call('exception', [new AuthorizationTokenExpiredException]);
        }

        //if exists start google login
        if ($this->existsAccountByEmail($socialiteUser->getEmail())) {
            return $this->loginGoogleAuth();
        }

        /** @var InitGooglePipelineDto $dto */
        [$dto, $e] = $this->registerPipeline->initGoogleAuth($request->dto());

        if (!$e) {
            $familyName = $socialiteUser->offsetExists('family_name') ? ucfirst(strtolower($socialiteUser->offsetGet('family_name'))) : '';

            return response()->json([
                'data' => [
                    'email' => $dto->getEmail()->getEmail(),
                    'first_name' => ucfirst(strtolower($socialiteUser->offsetGet('given_name'))),
                    'last_name' => $familyName,
                ]
            ]);
        }

        return response()->__call('exception', [$e]);
    }

    /**
     * @param ConfirmGoogleRequest $request
     * @return JsonResponse
     */
    public function confirmGoogleAuth(ConfirmGoogleRequest $request): JsonResponse
    {
        [$dto, $e] = $this->registerPipeline->confirmGoogleAuth($request->dto());

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
            'url' => Socialite::driver('sign-in-with-apple')
                ->stateless()
                ->redirect()
                ->getTargetUrl(),
        ]);
    }

    /**
     * @param InitAppleRequest $request
     * @return JsonResponse
     */
    public function initAppleAuth(InitAppleRequest $request): JsonResponse
    {
        //@fixme-v
//        try {
//            /** @var SocialiteUser $socialiteUser */
//            $socialiteUser = Socialite::driver('sign-in-with-apple')->stateless()->user();
//        } catch (ClientException $e) {
//            return response()->__call('exception', [new AuthorizationTokenExpiredException]);
//        }

        //@fixme-v
        //if exists, start login
//        if ($this->existsAccountByAppleId($socialiteUser->getId())) {
//            return $this->loginGoogleAuth();
//        }

        /** @var InitApplePipelineDto $dto */
        [$dto, $e] = $this->registerPipeline->initAppleAuth($request->dto());

        if (!$e) {
//            return response()->json([
//                'data' => [
//                    'email' => $dto->getAppleAccount()->getAppleId(),
//                    'email' => strtolower($socialiteUser->getEmail() ?? ''),
//                    'first_name' => $socialiteUser->offsetExists('firstName') ? $socialiteUser->offsetGet('firstName') : '',
//                    'last_name' => $socialiteUser->offsetExists('lastName') ? $socialiteUser->offsetGet('lastName') : '',
//                ]
//            ]);

            return response()->json([
                'data' => [
                    'apple_id' => 'apple_id',
                    'email' => 'email@gmail.com',
                    'first_name' => 'first',
                    'last_name' => 'last',
                ]
            ]);
        }

        return response()->__call('exception', [$e]);
    }


    public function checkUserEmailAppleAuth(ConfirmGoogleRequest $request): JsonResponse
    {
        [$dto, $e] = $this->registerPipeline->confirmGoogleAuth($request->dto());

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


    public function confirmAppleAuth(ConfirmGoogleRequest $request): JsonResponse
    {
        [$dto, $e] = $this->registerPipeline->confirmGoogleAuth($request->dto());

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

    private function loginAppleAuth(): JsonResponse
    {
        $request = new LoginGoogleRequest;

        /** @var LoginGooglePipelineDto $dto */
        [$dto, $e] = $this->loginPipeline->loginGoogle($request->dto());

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

    private function loginGoogleAuth(): JsonResponse
    {
        $request = new LoginGoogleRequest;

        /** @var LoginGooglePipelineDto $dto */
        [$dto, $e] = $this->loginPipeline->loginGoogle($request->dto());

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

    private function existsAccountByEmail(string $email): bool
    {
        if ($email = $this->emailService->get(['email' => $email])) {
            if ($email->getStatus() == EmailStatusEnum::Enabled->value
                || $email->getStatus() == EmailStatusEnum::Disabled->value) {
                if ($this->accountService->get(['uuid' => $email->getAccountUuid()])) {
                    return true;
                }
            }
        }
        return false;
    }
}
