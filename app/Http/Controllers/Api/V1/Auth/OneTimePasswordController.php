<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Dto\Pipelines\Api\V1\Auth\OneTimePassword\InitPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\OneTimePassword\ResendPipelineDto;
use App\Http\Requests\Api\V1\Auth\OneTimePassword\InitRequest;
use App\Http\Requests\Api\V1\Auth\OneTimePassword\ResendRequest;
use App\Pipelines\V1\Auth\OneTimePassword\OneTimePasswordPipeline;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class OneTimePasswordController extends Controller
{
    public function __construct(
        private readonly OneTimePasswordPipeline $pipeline,
    ) {
    }

    /**
     * @param InitRequest $request
     * @return JsonResponse
     */
    public function init(InitRequest $request): JsonResponse
    {
        /** @var InitPipelineDto $dto */
        [$dto, $e] = $this->pipeline->init($request->dto());

        if (!$e) {
            return response()->json();
        }

        return response()->__call('exception', [$e]);
    }

    /**
     * @param ResendRequest $request
     * @return JsonResponse
     */
    public function resend(ResendRequest $request): JsonResponse
    {
        /** @var ResendPipelineDto $dto */
        [$dto, $e] = $this->pipeline->resend($request->dto());

        if (!$e) {
            return response()->json();
        }

        return response()->__call('exception', [$e]);
    }
}
