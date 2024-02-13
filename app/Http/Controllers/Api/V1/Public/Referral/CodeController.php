<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Referral;

use App\Enums\Referrals\Code\StatusEnum;
use App\Services\Api\V1\Referrals\CodeService;
use App\Http\Requests\Api\V1\Public\Referral\Code\CheckRequest;

use App\Services\Api\V1\Settings\GlobalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class CodeController extends Controller
{
    public function __construct(
        private readonly CodeService $codeService,
        private readonly GlobalService $globalService,
    ) {
    }

    public function check(CheckRequest $request): JsonResponse
    {
        if ($code = $this->codeService->get([
            'code' => $request->dto()->getCode(),
            'status' => StatusEnum::Enabled->value,
        ])) {
            return response()->json([
                'data' => [
                    'exists' => true,
                    'increased_minimum_apy' => $code?->getIncreasedMinimumApy() ?? $this->globalService->getIncreasedMinimumApyValue(),
                ],
            ]);
        }

        return response()->json([
            'data' => [
                'exists' => false,
            ],
        ]);
    }
}
