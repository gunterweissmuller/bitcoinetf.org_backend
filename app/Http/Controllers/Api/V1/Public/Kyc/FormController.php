<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Kyc;

use App\Dto\Pipelines\Api\V1\Public\Kyc\Form\GetPipelineDto;
use App\Http\Requests\Api\V1\Public\Kyc\Form\GetRequest;
use App\Pipelines\V1\Public\Kyc\Form\FormPipeline;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class FormController extends Controller
{
    public function __construct(
        private readonly FormPipeline $pipeline,
    ) {
    }

    public function get(GetRequest $request): JsonResponse
    {
        /** @var GetPipelineDto $dto */
        [$dto, $e] = $this->pipeline->get($request->dto());

        if (!$e) {
            return response()->json([
                'data' => $dto->getOutput(),
            ]);
        }

        return response()->__call('exception', [$e]);
    }
}
