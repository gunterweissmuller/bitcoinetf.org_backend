<?php

declare(strict_types=1);

namespace app\Http\Controllers\Api\V3\Public\Billing\Shares\Buy\MoonPay;

use App\Enums\Billing\Wallet\TypeEnum as WalletTypeEnum;
use App\Http\Requests\Api\EmptyRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use App\Services\Api\V1\Apollopayment\ApollopaymentWebhooksService;
use App\Pipelines\V1\Public\Billing\Shares\Buy\Blockchain\Tron\TronPipeline;
use App\Http\Requests\Api\V3\Public\Billing\Shares\Buy\MoonPayWebhookRequest;

class MoonPayController extends Controller
{
    public function __construct(
        private readonly ApollopaymentWebhooksService $apollopaymentWebhooksService,
        private readonly TronPipeline $pipeline,
    )
    {
    }

    public function webhook(MoonPayWebhookRequest $request): JsonResponse
    {
        $data = $request->all();
        Log::info('MoonPay webhook', $data);
        if ($data['data']['status'] === 'pending') {
           return response()->json(['status' => 'pending']);
        }
        if ($webhook = $this->apollopaymentWebhooksService->get([
            'webhook_id' => $data['data']['id'],
            'type' => 'completed',
        ])) {
            return response()->json(['status' => 'duplicate']);
        }

        $this->apollopaymentWebhooksService->createMoonPayWebhookRecord($request);

        [$dto, $e] = $this->pipeline->callback($request->dto());

        if (!$e) {
            return response()->json([]);
        }

        return response()->__call('exception', [$e]);
    }

}
