<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Shares\Buy\Blockchain\Tron;

use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Blockchain\Tron\CallbackPipelineDto;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\V1\Public\Billing\Shares\Buy\Blockchain\Tron\Pipes\Callback\ReplenishmentPipe as CallbackReplenishmentPipe;
use App\Pipelines\V1\Public\Billing\Shares\Buy\Blockchain\Tron\Pipes\Callback\RestakePipe as CallbackRestakePipe;
use App\Pipelines\V1\Public\Billing\Shares\Buy\Blockchain\Tron\Pipes\Callback\PapTronPipe as CallbackPapTronSalePipe;
use App\Pipelines\V1\Public\Billing\Shares\Buy\Blockchain\Tron\Pipes\Callback\OrderTypeTronPipe as CallbackOrderTypeTronPipe;

class TronPipeline extends AbstractPipeline
{
    public function callback(CallbackPipelineDto $dto): array
    {
        return $this->pipeline([
            CallbackReplenishmentPipe::class,
            CallbackRestakePipe::class,
            CallbackPapTronSalePipe::class,
            CallbackOrderTypeTronPipe::class,
        ], $dto);
    }
}
