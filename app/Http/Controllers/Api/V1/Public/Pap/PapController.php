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
use App\Http\Requests\Api\V1\Public\Billing\Shares\Buy\Blockchain\Tron\CallbackRequest;
use App\Pipelines\V1\Public\Billing\Shares\Buy\Blockchain\Tron\TronPipeline;
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

    public function saleTron(Request $request): JsonResponse
    {   
        $account_uuid = $request->input('account_uuid');
        $real_amount = $request->input('real_amount');
        $record = $this->trackingService->get(['account_uuid' => $account_uuid]);
        if ($record !== null) {
            $this->trackingService->createSale($account_uuid, $real_amount, AssetEnum::Tron->value);
            return response()->json([]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'this account_uuid does not exist in the pap tracking table',
            ]);    
        }
    }

    public function saleMerchant001(Request $request): JsonResponse
    {   
        $account_uuid = $request->input('account_uuid');
        $real_amount = $request->input('real_amount');
        $record = $this->trackingService->get(['account_uuid' => $account_uuid]);
        if ($record !== null) {
            $this->trackingService->createSale($account_uuid, $real_amount, AssetEnum::FiatMerchant001->value);
            return response()->json([]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'this account_uuid does not exist in the pap tracking table',
            ]);    
        }
    } 
    
}
