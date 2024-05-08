<?php

declare(strict_types=1);

namespace app\Console\Commands\V1\Billing;

use App\Enums\Users\Account\StatusEnum;
use App\Models\Users\Account;
use App\Services\Api\V1\Users\AccountService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

use App\Services\Api\V1\Billing\PaymentService;

final class CheckPaymentForUsersCommand extends Command
{
    private const COUNT = 400;

    protected $signature = 'order-type:correct-by-payments';

    protected $description = 'Check users order_type by payments';

    public function handle(
        AccountService              $accountService,
        PaymentService              $paymentService,
    ): void
    {
        $count = 0;
        $countBtc = 0;
        $countUsdt = 0;
        $countBtcWithPayments = 0;
        $countUsdtWithPayments = 0;
        $updatedDataCount = 0;

        $callback = function (Collection $items) use ($accountService, $paymentService, &$count, &$countBtc, &$countUsdt, &$countBtcWithPayments, &$countUsdtWithPayments, &$updatedDataCount) {
            $items->map(function (Account $item) use ($accountService, $paymentService, &$count, &$countBtc, &$countUsdt, &$countBtcWithPayments, &$countUsdtWithPayments, &$updatedDataCount) {
                $count++;
                $itemArray = $item->toArray();
                if ($itemArray['order_type'] === 'btc') {
                    $countBtc++;
                    $result = $paymentService->getLastUserPayment($itemArray['uuid']);
                    if ($result) {
                        $countBtcWithPayments++;
                    } else {
                        $accountService->update([
                            'uuid' => $itemArray['uuid'],
                        ], [
                            'order_type' => null,
                        ]);
                        $updatedDataCount++;
                    }
                } else if ($itemArray['order_type'] === 'usdt'){
                    $countUsdt++;
                    $result = $paymentService->getLastUserPayment($itemArray['uuid']);
                    if ($result) {
                        $countUsdtWithPayments++;
                    } else {
                        $accountService->update([
                            'uuid' => $itemArray['uuid'],
                        ], [
                            'order_type' => null,
                        ]);
                        $updatedDataCount++;
                    }
                } else {
                    $result = $paymentService->getLastUserPayment($itemArray['uuid']);
                    if ($result) {
                        $accountService->update([
                            'uuid' => $itemArray['uuid'],
                        ], [
                            'order_type' => 'btc',
                        ]);
                        $updatedDataCount++;
                    }
                    echo '.';
                }
            });
        };

        $this->info("Check users order_type by payments: Process started ...");

        $accountService->allByFiltersWithChunk([
            ['users.accounts.status', '=', StatusEnum::Enabled->value],
        ], self::COUNT, $callback);

        $this->info("Check users order_type by payments: Process finished. Checked - $count, Updated - $updatedDataCount");
        $this->info("CountBtc - $countBtc, CountBtcWithPayments - $countBtcWithPayments, CountUsdt - $countUsdt, CountUsdtWithPayments - $countUsdtWithPayments");
        $deviationBtc = $countBtc - $countBtcWithPayments;
        $deviationUsdt = $countUsdt - $countUsdtWithPayments;
        $this->info("DeviationBtc - $deviationBtc, DeviationUsdt - $deviationUsdt");
    }
}
