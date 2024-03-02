<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Pap;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Enums\Pap\Event\EventEnum;
use App\Enums\Pap\Asset\AssetEnum;
use Illuminate\Support\Str;
use App\Services\Api\V1\Users\AccountService;
use App\Http\Requests\Api\V1\Public\Pap\Signup\PapSignupRequest;
use App\Exceptions\Pipelines\V1\Pap\PapTrackerAlreadyInUseException;
use App\Services\Api\V1\Pap\TrackingService;

final class PapController extends Controller
{
    public function __construct(
        private readonly AccountService $accountService,
        private readonly TrackingService $trackingService,
    ) {}

    public function signup(PapSignupRequest $request): JsonResponse
    {
        $account = $this->accountService->get(['uuid' => $request->payload()->getUuid()]);
        $account_uuid = $account->getUuid();
        $record = $this->trackingService->get(['account_uuid' => $account_uuid]);
        if ($record !== null) {
            return response()->__call('exception', [new PapTrackerAlreadyInUseException()]);
        } else {
            $this->trackingService->createSignup($account_uuid, $request->input('pap_id'), $request->input('utm_label'));
            return response()->json([]);
        }
    }
   
}
