<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\Pipes\Payment;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\PaymentPipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\ReplenishmentService;
use App\Services\Api\V1\Settings\GlobalService;
use App\Services\Utils\Merchant001Service;
use Closure;

final class TransactionPipe implements PipeInterface
{
    public function __construct(
        private readonly GlobalService $globalService,
        private readonly ReplenishmentService $replenishmentService,
        private readonly Merchant001Service $merchant001Service,
    ) {
    }

    public function handle(PaymentPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $replenishment = $dto->getReplenishment();

        if (!$replenishment->getMerchant001Id()) {
            if ($replenishment->getRealAmount() > 1000) {
                $replenishment->setRealAmount(1000);
            } elseif ($replenishment->getRealAmount() < $this->globalService->getMinReplenishmentAmount()) {
                $replenishment->setRealAmount($this->globalService->getMinReplenishmentAmount());
            }

            $rate = $this->merchant001Service->rate()['rate'] ?? 1;
            $amount = $replenishment->getRealAmount() * $rate;

            $transaction = $this->merchant001Service->createTransaction(
                $amount,
                $dto->getMethod(),
                $replenishment->getUuid(),
            );

            $replenishment->setMerchant001Id($transaction['id']);

            $this->replenishmentService->update([
                'uuid' => $replenishment->getUuid(),
            ], [
                'merchant001_id' => $replenishment->getMerchant001Id(),
            ]);

            $dto->setReplenishment($replenishment);
        }

        return $next($dto);
    }
}
