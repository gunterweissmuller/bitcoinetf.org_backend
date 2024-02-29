<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Pap;

include app_path() . '/Helpers/PapApiNamespace.class.php';

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Qu\Pap\Api\Pap_Api_SaleTracker;
use Illuminate\Http\Request;
use App\Models\Pap\Tracking;
use App\Enums\Pap\Event\EventEnum;
use App\Enums\Pap\Asset\AssetEnum;
use Illuminate\Support\Str;
use App\Services\Api\V1\Users\AccountService;
use App\Http\Requests\Api\V1\Public\Pap\Signup\PapSignupRequest;

final class PapController extends Controller
{
    public function __construct(
        private readonly AccountService $accountService,
    ) {}

    public function signup(PapSignupRequest $request): JsonResponse
    {
        $account = $this->accountService->get(['uuid' => $request->payload()->getUuid()]);
        $account_uuid = $account->getUuid();
        $record = Tracking::where('account_uuid', $account_uuid)->first();
        if ($record !== null) {
            return response()->json([
                'status' => 400,
                'message' => 'this account_uuid already exists in the pap tracking table',
            ]);
        } else {
            $tracking = new Tracking();
            $tracking->account_uuid = $account_uuid; 
            $tracking->event_type = EventEnum::Signup->value;
            $tracking->pap_id = $request->input('pap_id');
            $tracking->utm_label = $request->input('utm_label');
            $tracking->save();
            return response()->json([
                'status' => 200,
                'message' => 'signup event to pap tracking table ok',
            ]);
        }
    }

    public function saleTron(Request $request): JsonResponse
    {   
        $account_uuid = $request->input('account_uuid');
        $real_amount = $request->input('real_amount');
        $record = Tracking::where('account_uuid', $account_uuid)->first();
        if ($record !== null) {
            $saleTracker = new Pap_Api_SaleTracker(PAP_SALE_TRACKER_HOST);
            $saleTracker->setAccountId(PAP_ACCOUNT_ID);
            $sale1 = $saleTracker->createSale();
            $sale1->setTotalCost($real_amount);
            $saleTracker->register();
            $tracking = new Tracking();
            $tracking->account_uuid = $account_uuid; 
            $tracking->event_type = EventEnum::Sale->value;
            $tracking->real_amount = $real_amount;
            $tracking->amount_type = AssetEnum::Tron->value;;
            $tracking->save();
            return response()->json([
                'status' => 200,
                'message' => 'sale event send to pap and to pap tracking table ok',
            ]);
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
        $record = Tracking::where('account_uuid', $account_uuid)->first();
        if ($record !== null) {
            $saleTracker = new Pap_Api_SaleTracker(PAP_SALE_TRACKER_HOST);
            $saleTracker->setAccountId(PAP_ACCOUNT_ID);
            $sale1 = $saleTracker->createSale();
            $sale1->setTotalCost($real_amount);
            $saleTracker->register();
            $tracking = new Tracking();
            $tracking->account_uuid = $account_uuid; 
            $tracking->event_type = EventEnum::Sale->value;
            $tracking->real_amount = $real_amount;
            $tracking->amount_type = AssetEnum::FiatMerchant001->value;;
            $tracking->save();
            return response()->json([
                'status' => 200,
                'message' => 'sale event send to pap and to pap tracking table ok',
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'this account_uuid does not exist in the pap tracking table',
            ]);    
        }
    }   
}
