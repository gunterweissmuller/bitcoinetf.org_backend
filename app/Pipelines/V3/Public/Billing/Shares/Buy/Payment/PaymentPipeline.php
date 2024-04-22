<?php

declare(strict_types=1);

namespace App\Pipelines\V3\Public\Billing\Shares\Buy\Payment;

use App\Dto\Pipelines\Api\V3\Public\Billing\Shares\Buy\Payment\CancelOrderPipelineDto;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\V3\Public\Billing\Shares\Buy\Payment\Pipes\CancelOrder\ReplenishmentPipe as CancelOrderReplenishmentPipe;
use App\Pipelines\V3\Public\Billing\Shares\Buy\Payment\Pipes\CancelOrder\ValidatePipe as CancelOrderValidatePipe;
use App\Pipelines\V3\Public\Billing\Shares\Buy\Payment\Pipes\CancelOrder\WalletPipe as CancelOrderWalletPipe;

class PaymentPipeline extends AbstractPipeline
{
    /**
     * @param CancelOrderPipelineDto $dto
     * @return array
     */
    public function cancelOrder(CancelOrderPipelineDto $dto): array
    {
        return $this->pipeline([
            CancelOrderValidatePipe::class,
            CancelOrderReplenishmentPipe::class,
            CancelOrderWalletPipe::class,
        ], $dto);
    }
}

