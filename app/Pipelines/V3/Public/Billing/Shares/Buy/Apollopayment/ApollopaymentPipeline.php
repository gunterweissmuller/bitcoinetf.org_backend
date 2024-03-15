<?php

declare(strict_types=1);

namespace App\Pipelines\V3\Public\Billing\Shares\Buy\Apollopayment;

use App\Dto\Pipelines\Api\V3\Public\Billing\Shares\Buy\Apollopayment\CallbackPipelineDto;
use App\Pipelines\AbstractPipeline;

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
}
