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

final class PapController extends Controller
{
    public function __construct(
        
    ) {}

    public function signup(Request $request): JsonResponse
    {
        $account_uuid = (string) Str::uuid();
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

    public function sale(Request $request): JsonResponse
    {   
        $account_uuid = (string) Str::uuid();
        $real_amount = $request->input('real_amount');
        $saleTracker = new Pap_Api_SaleTracker(PAP_SALE_TRACKER_HOST);
        $saleTracker->setAccountId(PAP_ACCOUNT_ID);
        $sale1 = $saleTracker->createSale();
        $sale1->setTotalCost($real_amount);
        $sale1->setOrderID('staging');
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
    }

    
}
