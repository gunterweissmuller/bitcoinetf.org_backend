<?php

declare(strict_types=1);

namespace App\Console\Commands\V1\Billing;

use App\Enums\Billing\Replenishment\StatusEnum;
use App\Services\Api\V1\Billing\ReplenishmentService;
use App\Services\Api\V1\Billing\WalletService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

final class CheckExpiredReplenishmentsCommand extends Command
{
    protected $signature = 'billing:check-expired-replenishments';

    protected $description = 'Отключение просроченных пополнений';

    public function handle(
        ReplenishmentService $replenishmentService,
        WalletService        $walletService
    ): void
    {
        if ($replenishments = $replenishmentService->all([
            'status' => StatusEnum::INIT->value,
            ['created_at', '<=', Carbon::now()->subMinutes(30)->toDateTimeString()],
        ])) {
            foreach ($replenishments as $replenishment) {
                if ($replenishment->getDividendWalletUuid()) {
                    $this->refund(
                        $walletService,
                        $replenishment->getDividendWalletUuid(),
                        $replenishment->getDividendAmount(),
                        $replenishment->getDividendBtcAmount(),
                    );
                }

                if ($replenishment->getReferralWalletUuid()) {
                    $this->refund(
                        $walletService,
                        $replenishment->getReferralWalletUuid(),
                        $replenishment->getReferralAmount(),
                        0,
                    );
                }

                if ($replenishment->getBonusWalletUuid()) {
                    $this->refund(
                        $walletService,
                        $replenishment->getBonusWalletUuid(),
                        $replenishment->getBonusAmount(),
                        0,
                    );
                }

                $replenishmentService->update([
                    'uuid' => $replenishment->getUuid(),
                ], [
                    'status' => StatusEnum::EXPIRED->value,
                ]);
            }
        }
    }

    private function refund(WalletService $walletService, string $walletUuid, float $amount, float $btcAmount): void
    {
        if ($wallet = $walletService->get(['uuid' => $walletUuid])) {
            $walletService->update([
                'uuid' => $wallet->getUuid(),
            ], [
                'amount' => $wallet->getAmount() + $amount,
                'btc_amount' => $wallet->getBtcAmount() + $btcAmount,
            ]);
        }
    }
}
