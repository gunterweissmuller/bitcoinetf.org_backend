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
        $saleTracker = new Pap_Api_SaleTracker('https://bitcoinetf.postaffiliatepro.com/scripts/sale.php');

        $saleTracker->setAccountId('bitcoinetf.postaffiliatepro.com');

        //if you need to set customer's IP use this row, otherwise is used IP recognized from $_SERVER['REMOTE_ADDR']
        $saleTracker->setIp('127.0.0.1');

        $sale1 = $saleTracker->createSale();
        $sale1->setTotalCost('100');
        $sale1->setOrderID('staging');
        $sale1->setProductID('replenishment');
        $sale1->doNotDeleteCookies();

        $saleTracker->register();

        return response()->json([
            'status' => 200,
            'message' => 'sale send to pap ok',
        ]);
    }

    
}
