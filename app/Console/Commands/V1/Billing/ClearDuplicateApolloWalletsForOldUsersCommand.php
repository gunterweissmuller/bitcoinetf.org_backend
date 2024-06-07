<?php

declare(strict_types=1);

namespace App\Console\Commands\V1\Billing;

use App\Models\Apollopayment\Clients;
use App\Services\Api\V3\Apollopayment\ApollopaymentClientsService;
use App\Services\Api\V3\Apollopayment\ApollopaymentService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

final class ClearDuplicateApolloWalletsForOldUsersCommand extends Command
{
    private const COUNT = 400;

    protected $signature = 'apollopayment:clear-duplicate-apollo-wallets-for-old-users';

    protected $description = 'Clear duplicate wallets for old users';

    public function handle(
        ApollopaymentClientsService $apollopaymentClient,
        ApollopaymentService        $apollopaymentService
    ): void
    {
        $count = 0;

        $callback = function (Collection $items) use ($apollopaymentClient, $apollopaymentService, &$count) {
            $items->map(function (Clients $item) use ($apollopaymentClient, $apollopaymentService, &$count) {
                $count++;
                $itemArray = $item->toArray();
                if (!is_null($itemArray['ethereum_addr'])) {
                    $apollopaymentClient->deleteDuplicate(['account_uuid' => $itemArray['account_uuid']], $itemArray['uuid']);
                    echo '.';
                }
            });
        };

        $this->info("Clear duplicate wallets for old users: Process started ...");

        $apollopaymentClient->allByFiltersWithChunk([
            ['ethereum_addr', '!=', null],
        ], self::COUNT, $callback);

        $this->info("Clear duplicate wallets for old users: Process finished. Checked - $count");
    }
}
