<?php

declare(strict_types=1);

namespace App\Console\Commands\V1\Billing;

use App\Dto\Utils\ApollopaymentApi\GetUserAllAddressesDto;
use App\Models\Apollopayment\Clients;
use App\Services\Api\V3\Apollopayment\ApollopaymentClientsService;
use App\Services\Api\V3\Apollopayment\ApollopaymentService;
use App\Services\Utils\ApollopaymentApiService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

final class MakeWalletsForExistingUsersWithoutWalletCommand extends Command
{
    private const COUNT = 400;

    protected $signature = 'apollopayment:make-wallets-for-existing-users-without-wallet';

    protected $description = 'Make wallets for existing users';

    public function handle(
        ApollopaymentClientsService $apollopaymentClientsService,
        ApollopaymentService        $apollopaymentService,
        ApollopaymentApiService     $apollopaymentApiService,
    ): void
    {
        $count = 0;
        $updatedDataCount = 0;

        $callback = function (Collection $items) use ($apollopaymentClientsService, $apollopaymentService, $apollopaymentApiService, &$count, &$updatedDataCount) {

            $items->map(function (Clients $item) use ($apollopaymentClientsService, $apollopaymentService, $apollopaymentApiService, &$count, &$updatedDataCount) {
                $count++;
                $itemArray = $item->toArray();

                $allAddressesDto = GetUserAllAddressesDto::fromArray(
                    [
                        'id' => $itemArray['client_id'],
                        'network' => ['ethereum', 'polygon', 'tron'],
                        'currency' => ['USDT'],
                    ]
                );

                try {
                    $responseWalletAddresses = $apollopaymentApiService->getUserAllAddresses($allAddressesDto);

                    if ($responseWalletAddresses['success']) {
                        $updateData = [];

                        foreach ($responseWalletAddresses['response']['addresses'] as $walletAddress) {
                            switch ($walletAddress['network']) {
                                case 'ethereum':
                                    $updateData['ethereum_addr'] = $walletAddress['address'];
                                    break;
                                case 'tron':
                                    $updateData['tron_addr'] = $walletAddress['address'];
                                    break;
                                case 'polygon':
                                    $updateData['polygon_addr'] = $walletAddress['address'];
                                    break;
                            }
                        }

                        if (!empty($updateData)) {
                            $apollopaymentClientsService->update(['uuid' => $itemArray['uuid']], $updateData);
                            $updatedDataCount++;
                        }
                        echo '.';
                    } else {
                        $this->info("Make wallets for existing users: Cannot create wallet for this user - " . $itemArray['account_uuid'] . ' Error Message: Cannot get wallets');
                    }

                } catch (\Throwable $e) {
                    $this->info("Make wallets for existing users: Cannot create wallet for this user - " . $itemArray['account_uuid'] . ' Error Message: ' . $e->getMessage());
                }
            });
        };

        $this->info("Make wallets for existing users: Process started ...");

        $apollopaymentClientsService->allByFiltersWithChunk([
            ['ethereum_addr', '=', null],
        ], self::COUNT, $callback);

        $this->info("Make wallets for existing users: Process finished. Checked - $count, Updated - $updatedDataCount");
    }
}
