<?php

declare(strict_types=1);

namespace App\Pipelines\V3\Public\Billing\Shares\Buy\Apollopayment;

use App\Dto\Pipelines\Api\V3\Public\Billing\Shares\Buy\Apollopayment\CallbackPipelineDto;
use App\Dto\Pipelines\Api\V3\Public\Billing\Shares\Buy\Apollopayment\CancelOrderPipelineDto;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\V3\Public\Billing\Shares\Buy\Apollopayment\Pipes\CancelOrder\ReplenishmentPipe as CancelOrderReplenishmentPipe;
use App\Pipelines\V3\Public\Billing\Shares\Buy\Apollopayment\Pipes\CancelOrder\ValidatePipe as CancelOrderValidatePipe;
use App\Pipelines\V3\Public\Billing\Shares\Buy\Apollopayment\Pipes\CancelOrder\WalletPipe as CancelOrderWalletPipe;

class ApollopaymentPipeline extends AbstractPipeline
{
    public function callback(CallbackPipelineDto $dto): array
    {
        return $this->pipeline([
            CallbackReplenishmentPipe::class,
            CallbackRestakePipe::class,
            CallbackPapTronSalePipe::class,
        ], $dto);
    }

    public function cancelOrder(CancelOrderPipelineDto $dto): array
    {
        return $this->pipeline([
            CancelOrderValidatePipe::class,
            CancelOrderReplenishmentPipe::class,
            CancelOrderWalletPipe::class,
        ], $dto);
    }
}
