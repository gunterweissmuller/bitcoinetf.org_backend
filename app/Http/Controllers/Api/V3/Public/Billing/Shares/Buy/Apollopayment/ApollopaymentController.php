<?php

declare(strict_types=1);

namespace app\Http\Controllers\Api\V3\Public\Billing\Shares\Buy\Apollopayment;

use App\Http\Requests\Api\EmptyRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

class ApollopaymentController extends Controller
{
    public function __construct(
    ) {
    }

    public function methods(EmptyRequest $request): JsonResponse
    {
        return response()->json([
            'data' => [
                'methods' => [
                    [
                        'currency' => 'Tether USD',
                        'network' => 'tron',
                        'address' => 'TKn1s2NBirDJdcLkNd4EsHpv63veCCtaot',
                    ],
                    [
                        'currency' => 'Tether USD',
                        'network' => 'polygon',
                        'address' => '0xeC4180b26b61A4E305AEB32Dc1B0db9E69c4d9bA',
                    ],
                    [
                        'currency' => 'Tether USD',
                        'network' => 'ethereum',
                        'address' => '0xA3275F4e819Cf6707f7607E237336C950487793d',
                    ],
                ],
            ],
        ]);
    }

    public function check(EmptyRequest $request): JsonResponse
    {
        return response()->json([
            'data' => [
                'status' => 'ok',
                'from' => 'check',
            ],
        ]);
    }

    public function webhook(EmptyRequest $request): JsonResponse
    {
        return response()->json([
            'data' => [
                'status' => 'ok',
                'from' => 'webhook',
            ],
        ]);
    }

}
