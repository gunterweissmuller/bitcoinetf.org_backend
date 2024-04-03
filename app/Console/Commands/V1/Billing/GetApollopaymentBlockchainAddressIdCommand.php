<?php

declare(strict_types=1);

namespace App\Console\Commands\V1\Billing;

use App\Services\Utils\ApollopaymentApiService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

final class GetApollopaymentBlockchainAddressIdCommand extends Command
{
    protected $signature = 'apollopayment:get-blockchain-address-id';

    protected $description = 'Автоматическая выплата дивидендов типом Polygon USDT';

    public function handle(
        ApollopaymentApiService $apollopaymentApiService,
    ): void
    {
        $this->info('Started Apollo payment: blockchain address command ...');
        try {
            $blockchainData = $apollopaymentApiService->getBlockchainByAddress(env('APOLLO_PAYMENT_BASIC_WALLET_POLYGON_USDT_ADDRESS'));
            if ($blockchainData['success'] && $blockchainData['response']) {
                $message = 'Set this address id in .env APOLLO_PAYMENT_BASIC_WALLET_POLYGON_USDT_ADDRESS_ID - ' . $blockchainData['response'][0]['id'];
            } else {
                $message = 'Response from apollo payment is empty. Check APOLLO_PAYMENT_BASIC_WALLET_POLYGON_USDT_ADDRESS';
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            Log::error("Ended Apollo payment: $message");
        }
        $this->info("Ended Apollo payment: $message");
    }
}
