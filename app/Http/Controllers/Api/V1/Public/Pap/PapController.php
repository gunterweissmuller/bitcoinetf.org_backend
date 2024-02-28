<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Pap;

include app_path() . '/Helpers/PapApiNamespace.class.php';

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Qu\Pap\Api\Pap_Api_SaleTracker;

final class PapController extends Controller
{
    public function __construct(
        
    ) {}

    public function signup(): JsonResponse
    {
        return response()->json([
            'status' => 200,
            'message' => 'signup ok',
        ]);
    }

    public function sale(): JsonResponse
    {
        $saleTracker = new Pap_Api_SaleTracker(PAP_SALE_TRACKER_HOST);
        $saleTracker->setAccountId(PAP_ACCOUNT_ID);
        $sale1 = $saleTracker->createSale();
        $sale1->setTotalCost('100');
        $sale1->setOrderID('staging');
        $saleTracker->register();

        return response()->json([
            'status' => 200,
            'message' => 'sale send to pap ok',
        ]);
    }

    
}
