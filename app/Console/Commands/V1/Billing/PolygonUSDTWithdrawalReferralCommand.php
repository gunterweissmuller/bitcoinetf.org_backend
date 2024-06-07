<?php

declare(strict_types=1);

namespace App\Console\Commands\V1\Billing;

use App\Dto\Models\Billing\WalletDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\ReferralPipelineDto;
use App\Enums\Billing\Wallet\TypeEnum;
use App\Enums\Billing\Wallet\WithdrawalMethodEnum;
use App\Pipelines\V1\Public\Billing\Withdrawal\WithdrawalPipeline;
use App\Services\Api\V1\Billing\WalletService;
use App\Services\Api\V1\Users\AccountService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Command\Command as CommandAlias;

final class PolygonUSDTWithdrawalReferralCommand extends Command
{
    protected $signature = 'billing:apollo-polygon-usdt-withdrawal-referral';

    protected $description = 'Автоматическая выплата рефералов типом Polygon usdt';

    private const COUNT = 100;

    public function handle(
        WalletService      $walletService,
        WithdrawalPipeline $withdrawalPipeline,
        AccountService     $accountService
    ): void
    {
        $this->info("Start withdrawal referral ..........................");

        $callback = function (Collection $wallets) use ($withdrawalPipeline, $accountService) {

            foreach ($wallets as $wallet) {

                $wallet = WalletDto::fromArray($wallet->toArray());

                if ($accountService->get(['uuid' => $wallet->getAccountUuid(), 'allowed_withdrawal' => true])) {
                    [$dto, $e] = $withdrawalPipeline->referrals(ReferralPipelineDto::fromArray([
                        'wallet' => WalletDto::fromArray([
                            'account_uuid' => $wallet->getAccountUuid(),
                            'type' => TypeEnum::REFERRAL->value,
                        ]),
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
            'withdrawal_method' => WithdrawalMethodEnum::POLYGON_USDT->value,
            ['withdrawal_address', '!=', null],
            ['amount', '>', 0],
        ], self::COUNT, $callback);

        $this->info("End withdrawal referral ..........................");
    }
}
