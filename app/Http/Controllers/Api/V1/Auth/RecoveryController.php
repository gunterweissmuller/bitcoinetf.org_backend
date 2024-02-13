<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Dto\Pipelines\Api\V1\Auth\Recovery\ConfirmPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Recovery\InitPipelineDto;
use App\Enums\Auth\Code\StatusEnum;
use App\Enums\Auth\Code\TypeEnum;
use App\Exceptions\Pipelines\V1\Auth\IncorrectCodeException;
use App\Http\Requests\Api\V1\Auth\Recovery\CheckRequest;
use App\Http\Requests\Api\V1\Auth\Recovery\ConfirmRequest;
use App\Http\Requests\Api\V1\Auth\Recovery\InitRequest;
use App\Pipelines\V1\Auth\Recovery\RecoveryPipeline;
use App\Services\Api\V1\Auth\CodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class RecoveryController extends Controller
{
    public function __construct(
        private readonly CodeService $codeService,
        private readonly RecoveryPipeline $pipeline,
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

    public function check(CheckRequest $request): JsonResponse
    {
        $dto = $request->dto();
        $dto->setType(TypeEnum::PasswordRecovery->value);
        $dto->setStatus(StatusEnum::Unused->value);

        if ($this->codeService->get(array_filter($dto->toArray()))) {
            return response()->json();
        }

        throw new IncorrectCodeException();
    }

    public function confirm(ConfirmRequest $request): JsonResponse
    {
        /** @var ConfirmPipelineDto $dto */
        [$dto, $e] = $this->pipeline->confirm($request->dto());

        if (!$e) {
            return response()->json();
        }

        return response()->__call('exception', [$e]);
    }
}
