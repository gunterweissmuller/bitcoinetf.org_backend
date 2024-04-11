<?php

declare(strict_types=1);

namespace App\Console\Commands\V1\Billing;

use App\Enums\Users\Account\StatusEnum;
use App\Models\Users\Account;
use App\Services\Api\V1\Users\AccountService;
use App\Services\Api\V3\Apollopayment\ApollopaymentClientsService;
use App\Services\Api\V3\Apollopayment\ApollopaymentService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

final class MakeWalletsForOldUsersCommand extends Command
{
    private const COUNT = 400;

    protected $signature = 'apollopayment:make-wallets-for-old-users';

    protected $description = 'Make wallets for old users';

    public function handle(
        AccountService              $accountService,
        ApollopaymentClientsService $apollopaymentClient,
        ApollopaymentService        $apollopaymentService
    ): void
    {
        $count = 0;
        $updatedDataCount = 0;

        $callback = function (Collection $items) use ($apollopaymentClient, $apollopaymentService, &$count, &$updatedDataCount) {
            $items->map(function (Account $item) use ($apollopaymentClient, $apollopaymentService, &$count, &$updatedDataCount) {
                $count++;
                $itemArray = $item->toArray();
                $apollopaymentClientInfo = $apollopaymentClient->get(['account_uuid' => $itemArray['uuid']]);

                if (!$apollopaymentClientInfo) {
                    try {
                        $apollopaymentService->createUser(
                            $itemArray['uuid'],
                            $itemArray['email'],
                            $itemArray['full_name'],
                            $apollopaymentClientInfo
                        );
                        $updatedDataCount++;
                        $this->info("Make wallets for old users: created successfully for this user - " . $itemArray['uuid']);
                    } catch (\Exception $e) {
                        $this->info("Make wallets for old users: Cannot create wallet for this user - " . $itemArray['uuid'] . ' Error Message: ' . $e->getMessage());
                    }
                } else {
                    echo '.';
                }
            });
        };

        $this->info("Make wallets for old users: Process started ...");

        $accountService->allUserInfoByFiltersWithChunk([
            ['users.accounts.status', '=', StatusEnum::Enabled->value],
        ], self::COUNT, $callback);

        $this->info("Make wallets for old users: Process finished. Checked - $count, Updated - $updatedDataCount");
    }
}
