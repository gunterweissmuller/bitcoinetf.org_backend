<?php

declare(strict_types=1);

namespace App\Pipelines\V3\Public\Billing\Shares\Buy;

use App\Dto\Pipelines\Api\V3\Public\Billing\Shares\Buy\InitPipelineDto;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\V3\Public\Billing\Shares\Buy\Pipes\Init\ApolloClientPipe as InitApolloClientPipe;
use App\Pipelines\V3\Public\Billing\Shares\Buy\Pipes\Init\BonusPipe as InitBonusPipe;
use App\Pipelines\V3\Public\Billing\Shares\Buy\Pipes\Init\DividendsPipe as InitDividendsPipe;
use App\Pipelines\V3\Public\Billing\Shares\Buy\Pipes\Init\ReferralPipe as InitReferralPipe;
use App\Pipelines\V3\Public\Billing\Shares\Buy\Pipes\Init\ReplenishmentPipe as InitReplenishmentPipe;
use App\Pipelines\V3\Public\Billing\Shares\Buy\Pipes\Init\FillReplenishmentPipe as InitFillReplenishmentPipe;

class BuyPipeline extends AbstractPipeline
{
    public function init(InitPipelineDto $dto): array
    {
        return $this->pipeline([
            InitFillReplenishmentPipe::class,
            InitApolloClientPipe::class,
            InitBonusPipe::class,
            InitDividendsPipe::class,
            InitReferralPipe::class,
            InitReplenishmentPipe::class,
        ], $dto);
    }
}
