<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Referral;

use App\Dto\Pipelines\Api\V1\Public\Referral\Invite\ApplyPipelineDto;
use App\Http\Requests\Api\V1\Public\Referral\Invite\ApplyRequest;
use App\Pipelines\V1\Public\Referral\Invite\InvitePipeline;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class InviteController extends Controller
{
    public function __construct(
        private readonly InvitePipeline $pipeline,
    ) {
    }

    public function apply(ApplyRequest $request): JsonResponse
    {
        /** @var ApplyPipelineDto $dto */
        [$dto, $e] = $this->pipeline->apply($request->dto());

        if (!$e) {
            return response()->json();
        }

        return response()->__call('exception', [$e]);
    }
}
