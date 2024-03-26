<?php

declare(strict_types=1);

namespace app\Http\Controllers\Api\V3\Public\Billing\Shares\Buy\MoonPay;

use App\Http\Requests\Api\EmptyRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class MoonPayController extends Controller
{
    public function __construct()
    {
    }

    public function webhook(EmptyRequest $request): JsonResponse
    {
        return response()->json([
            'data' => [
                'status' => 'ok',
                'from' => 'moonpay webhook',
            ],
        ]);
    }
}
