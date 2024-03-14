<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Dto\Pipelines\Api\V1\Auth\Code\CheckPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Code\ResendPipelineDto;
use App\Http\Requests\Api\V1\Auth\Code\CheckRequest;
use App\Http\Requests\Api\V1\Auth\Code\ResendRequest;
use App\Pipelines\V1\Auth\Code\CodePipeline;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class CodeController extends Controller
{
    public function __construct(
        private readonly CodePipeline $pipeline,
    ) {
    }

    public function check(CheckRequest $request): JsonResponse
    {
        /** @var CheckPipelineDto $dto */
        [$dto, $e] = $this->pipeline->check($request->dto());

        if (!$e) {
            return response()->json();
        }

        return response()->__call('exception', [$e]);
    }

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
