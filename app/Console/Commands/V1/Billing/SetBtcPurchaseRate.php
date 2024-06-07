<?php

declare(strict_types=1);

namespace app\Console\Commands\V1\Billing;

use App\Enums\Users\Account\StatusEnum;
use App\Models\Users\Account;
use App\Services\Api\V1\Users\AccountService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

use App\Services\Api\V1\Billing\PaymentService;
use App\Services\Api\V3\Billing\BtcPurchaseService;

final class SetBtcPurchaseRate extends Command
{
    private const COUNT = 100;

    protected $signature = 'billing:set-btc-purchase-rate {value}';

    protected $description = 'Set btc purchase rate and update actual payments valuation base';

    public function handle(
        AccountService              $accountService,
        PaymentService              $paymentService,
        BtcPurchaseService          $btcPurchaseService,
    ): void
    {
        $count = 0;

        $callback = function (Collection $items) use ($accountService, $paymentService, &$count) {
            $items->map(function (Account $item) use ($accountService, $paymentService, &$count) {
                $count++;
                $itemArray = $item->toArray();
                $rate = $this->argument('value');
            });
        };

        $this->info("Set btc purchase rate and update actual payments valuation base: Process started ...");

        $accountService->allByFiltersWithChunk([
            ['users.accounts.status', '=', StatusEnum::Enabled->value],
        ], self::COUNT, $callback);

        $this->info("Set btc purchase rate and update actual payments valuation base. Checked - $count");

    }
}
