<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V3\Public\Billing\Shares\Buy\MoonPay;

use App\Enums\Billing\MoonPay\Webhook\TypeEnum as MoonPayWebhookTypeEnum;
use App\Services\Api\V3\Moonpay\MoonpayWebhooksService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use App\Pipelines\V1\Public\Billing\Shares\Buy\Blockchain\Tron\TronPipeline;
use App\Http\Requests\Api\V3\Public\Billing\Shares\Buy\MoonPayWebhookRequest;

class MoonPayController extends Controller
{
    public function __construct(
        private readonly MoonpayWebhooksService $moonpayWebhooksService,
        private readonly TronPipeline $pipeline,
    )
    {
    }

    public function webhook(MoonPayWebhookRequest $request): JsonResponse
    {
        $data = $request->all();
        Log::info('MoonPay webhook', $data);
        if ($data['data']['status'] === MoonPayWebhookTypeEnum::Pending->value) {
           return response()->json(['status' => MoonPayWebhookTypeEnum::Pending->value]);
        }
        if ($data['data']['status'] === MoonPayWebhookTypeEnum::Failed->value) {
            return response()->json(['status' => MoonPayWebhookTypeEnum::Failed->value]);
        }
        if ($this->moonpayWebhooksService->get([
            'webhook_id' => $data['data']['id'],
            'type' => MoonPayWebhookTypeEnum::Completed->value,
        ])) {
            return response()->json(['status' => 'duplicate']);
        }

        $this->moonpayWebhooksService->createMoonPayWebhookRecord($request);

        [$dto, $e] = $this->pipeline->callback($request->dto());

        if (!$e) {
            return response()->json([]);
        }

        return response()->__call('exception', [$e]);
    }

}
