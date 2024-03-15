<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Billing\Shares\Buy\Blockchain;

use App\Exceptions\Pipelines\V1\Billing\ReplenishmentNotAvailableException;
use App\Http\Requests\Api\EmptyRequest;
use App\Http\Requests\Api\V1\Public\Billing\Shares\Buy\Blockchain\Tron\CallbackRequest;
use App\Pipelines\V1\Public\Billing\Shares\Buy\Blockchain\Tron\TronPipeline;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

class TronController extends Controller
{
    public function __construct(
        private readonly TronPipeline $pipeline,
    ) {
    }

    public function check(EmptyRequest $request): JsonResponse
    {
        try {
            Http::baseUrl(env('PAYMENT_HOST'))
                ->withHeaders([
                    'Authorization' => 'Bearer '.env('PAYMENT_API_KEY'),
                ])
                ->post('/v2/users/transaction', [
                    'account_uuid' => $request->payload()->getUuid(),
                ])
                ->throw()
                ->json();

            return response()->json([]);
        } catch (Exception $e) {
            throw new ReplenishmentNotAvailableException();
        }
    }

    public function callback(CallbackRequest $request): JsonResponse
    {
        [$dto, $e] = $this->pipeline->callback($request->dto());

        if (!$e) {
            return response()->json([]);
        }

        return response()->__call('exception', [$e]);
    }
}
