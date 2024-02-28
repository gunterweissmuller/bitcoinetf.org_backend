<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Exceptions\Pipelines\V1\Auth\InvalidSignatureMetamaskException;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitPipelineDto;
use App\Http\Requests\Api\V1\Auth\Register\ConfirmRequest;
use App\Http\Requests\Api\V1\Auth\Register\InitRequest;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmMetamaskPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitMetamaskPipelineDto;
use App\Http\Requests\Api\V1\Auth\Register\ConfirmMetamaskRequest;
use App\Http\Requests\Api\V1\Auth\Register\InitMetamaskRequest;
use App\Pipelines\V1\Auth\Register\RegisterPipeline;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use App\Helpers\EcRecover;

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

    public function metamaskMessage(): JsonResponse
    {
        return response()->json([
            'message' => METAMASK_MSG
        ], 200);
    }

    public function metamaskInit(InitMetamaskRequest $request): JsonResponse
    {
        $walletAddress = Str::lower($request->wallet_address);
        $message   = $request->message;
        $signature = $request->signature;

        $valid = (new EcRecover)->verifySignature($message,  $signature,  $walletAddress);
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

}
