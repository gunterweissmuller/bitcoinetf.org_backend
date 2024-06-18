<?php

declare(strict_types=1);

namespace app\Console\Commands\V1\Billing;

use Illuminate\Console\Command;
use App\Services\Api\V1\Billing\PaymentService;
use App\Services\Api\V3\Billing\BtcPurchaseService;
use App\Dto\Models\Billing\BtcPurchaseDto;
use App\Models\Billing\BtcPurchase;
use Illuminate\Support\Carbon;
use App\Enums\Billing\Payment\TypeEnum as PaymentTypeEnum;

final class SetBtcPurchaseRate extends Command
{

    protected $signature = 'billing:set-btc-purchase-rate {value}';

    protected $description = 'Set btc purchase rate and update actual payments valuation base';

    public function handle(
        PaymentService              $paymentService,
        BtcPurchaseService          $btcPurchaseService,
    ): void
    {
        $paymentsUpdated = 0;
        $amountUpdated = 0;
        $rate = $this->argument('value');
        $this->info("Set btc purchase rate and update actual payments valuation base: Process started ...");
        $this->info("btc purchase rate - $rate");
        $lastPurchaseRecord = BtcPurchase::query()->latest('created_at')->first();
        $lastPurchaseTime = Carbon::now()->startOfDay()->toDateTimeString();
        if ($lastPurchaseRecord) {
            $lastPurchaseRecord = $lastPurchaseRecord->toArray();
            $lastPurchaseTime = $lastPurchaseRecord['created_at'];
        }
        $this->info("time last btc purchase - $lastPurchaseTime");
        if ($payments = $paymentService->all([
            'type'=> PaymentTypeEnum::CREDIT_FROM_CLIENT->value,
            ['created_at', '>', $lastPurchaseTime],
        ])) {
            foreach ($payments as $payment) {
                $payment = $payment->toArray();
                $amountUpdated += $payment['real_amount'];
                $totalAmountBtc = $payment['total_amount_btc'];
                $btcPriceBefore = $payment['btc_price'];
                $btcPriceAfter = (float)$rate > 0 ? (float)$rate : 1;
                $correction = $btcPriceBefore / $btcPriceAfter;
                $paymentService->update([
                    'uuid' => $payment['uuid'],
                ], [
                    'total_amount_btc' => $totalAmountBtc * $correction,
                    'btc_price' => (float)$rate,
                ]);
                $paymentsUpdated ++;
                echo '.';
            }
        }
        $purchaseRecord = $btcPurchaseService->create(BtcPurchaseDto::fromArray([
            'rate' => (float)$rate,
            'payments_updated' => $paymentsUpdated,
            'amount' => $amountUpdated,
        ]));
        $purchaseTime = $purchaseRecord->getCreatedAt();
        $this->info("Set btc purchase rate and update actual payments valuation base. Payments updates - $paymentsUpdated. Amount - $amountUpdated usd");
        $this->info("Created at - $purchaseTime. Rate 1 btc = (float)$rate usd");
    }
}
