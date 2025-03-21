<?php

declare(strict_types=1);

namespace App\Console\Commands\V1\Billing;

use App\Dto\Models\Billing\WalletDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\DividendPipelineDto;
use App\Enums\Billing\Wallet\TypeEnum;
use App\Enums\Billing\Wallet\WithdrawalMethodEnum;
use App\Enums\Billing\Withdrawal\MethodEnum;
use App\Pipelines\V1\Public\Billing\Withdrawal\WithdrawalPipeline;
use App\Services\Api\V1\Billing\WalletService;
use App\Services\Api\V1\Users\AccountService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Command\Command as CommandAlias;

final class BitcoinLightningWithdrawalCommand extends Command
{
    protected $signature = 'billing:bitcoin-lightning-withdrawal';

    protected $description = 'Автоматическая выплата дивидендов типом Bitcoin Lighting';

    private const COUNT = 100;

    public function handle(
        WalletService $walletService,
        WithdrawalPipeline $withdrawalPipeline,
        AccountService $accountService
    ): void {
        $callback = function (Collection $wallets) use ($withdrawalPipeline, $accountService) {
            foreach ($wallets as $wallet) {
                $wallet = WalletDto::fromArray($wallet->toArray());

                if ($accountService->get(['uuid' => $wallet->getAccountUuid(), 'allowed_withdrawal' => true])) {
                    [$dto, $e] = $withdrawalPipeline->dividends(DividendPipelineDto::fromArray([
                        'wallet' => WalletDto::fromArray([
                            'account_uuid' => $wallet->getAccountUuid(),
                            'type' => TypeEnum::DIVIDENDS->value,
                        ]),
                        'method' => MethodEnum::BITCOIN_LIGHTNING->value,
                    ]));

                    if ($e) {
                        $this->error($e);
                        return CommandAlias::FAILURE;
                    }
                }
            }

            return CommandAlias::SUCCESS;
        };

        $walletService->allByFiltersWithChunk([
            'withdrawal_method' => WithdrawalMethodEnum::BITCOIN_LIGHTNING->value,
            ['withdrawal_address', '!=', null],
            ['btc_amount', '>', 0],
        ], self::COUNT, $callback);
    }
}
