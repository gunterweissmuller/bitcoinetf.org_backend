<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Newsletter;

use App\Dto\Pipelines\Api\V1\Public\Newsletter\SubscribePipelineDto;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\V1\Public\Newsletter\Pipes\Subscribe\SubscribePipe;

final class SubscribePipeline extends AbstractPipeline
{
    public function subscribe(SubscribePipelineDto $dto): array
    {
        return $this->pipeline([
            SubscribePipe::class,
        ], $dto);
    }
}
