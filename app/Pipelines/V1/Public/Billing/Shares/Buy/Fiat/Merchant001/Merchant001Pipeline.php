<?php

namespace App\Pipelines\V1\Public\Billing\Shares\Buy\Fiat\Merchant001;

use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\CallbackPipelineDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\PaymentPipelineDto;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\Pipes\Callback\FailurePipe as CallbackFailurePipe;
use App\Pipelines\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\Pipes\Callback\ReplenishmentPipe as CallbackReplenishmentPipe;
use App\Pipelines\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\Pipes\Callback\SuccessPipe as CallbackSuccessPipe;
use App\Pipelines\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\Pipes\Callback\ValidatePipe as CallbackValidatePipe;
use App\Pipelines\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\Pipes\Payment\ReplenishmentPipe as PaymentReplenishmentPipe;
use App\Pipelines\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\Pipes\Payment\TransactionPipe as PaymentTransactionPipe;
use App\Pipelines\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\Pipes\Callback\PapMerchant001Pipe as CallbackPapFiatMerchant001SalePipe;


class Merchant001Pipeline extends AbstractPipeline
{
    public function payment(PaymentPipelineDto $dto): array
    {
        return $this->pipeline([
            PaymentReplenishmentPipe::class,
            PaymentTransactionPipe::class,
        ], $dto);
    }

    public function callback(CallbackPipelineDto $dto): array
    {
        return $this->pipeline([
            CallbackValidatePipe::class,
            CallbackReplenishmentPipe::class,
            CallbackSuccessPipe::class,
            CallbackFailurePipe::class,
            CallbackPapFiatMerchant001SalePipe::class,
        ], $dto);
    }
}
