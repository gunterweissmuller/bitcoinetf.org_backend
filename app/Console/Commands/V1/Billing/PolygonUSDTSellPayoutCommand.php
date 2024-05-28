<?php

declare(strict_types=1);

namespace app\Console\Commands\V1\Billing;

use App\Dto\Models\Billing\SellDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\PayoutPipelineDto;
use App\Enums\Billing\Withdrawal\StatusEnum;
use App\Enums\Billing\Withdrawal\MethodEnum;
use App\Pipelines\V1\Public\Billing\Withdrawal\WithdrawalPipeline;
use App\Services\Api\V3\Billing\SellService;
use App\Services\Api\V1\Users\AccountService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Command\Command as CommandAlias;

final class PolygonUSDTSellPayoutCommand extends Command
{
    protected $signature = 'billing:apollo-polygon-usdt-sold-payout';

    protected $description = 'Payout for sold ETF shares via apollopayment usdt polygon';

    private const COUNT = 100;

    public function handle(
        SellService      $sellService,
        WithdrawalPipeline $withdrawalPipeline,
        AccountService     $accountService
    ): void
    {
        $this->info("Start payout for sold etf shares ..........................");

        $callback = function (Collection $sells) use ($withdrawalPipeline, $accountService) {

            foreach ($sells as $sell) {

                $sell = SellDto::fromArray($sell->toArray());

                if ($accountService->get(['uuid' => $sell->getAccountUuid(), 'allowed_withdrawal' => true])) {
                    [$dto, $e] = $withdrawalPipeline->payout(PayoutPipelineDto::fromArray([
                        'sell' => $sell,
                    ]));

                    if ($e) {
                        $this->error($e);
                        return CommandAlias::FAILURE;
                    }
                }
            }

            return CommandAlias::SUCCESS;
        };

        $sellService->allByFiltersWithChunk([
            'method' => MethodEnum::POLYGON_USDT->value,
            'status' => StatusEnum::INIT->value,
            ['destination', '!=', null],
            ['value', '>', 0],
        ], self::COUNT, $callback);

        $this->info("End payout for sold etf shares ..........................");
    }
}
