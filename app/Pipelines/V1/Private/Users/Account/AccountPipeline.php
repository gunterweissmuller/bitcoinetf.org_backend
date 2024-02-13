<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\Users\Account;

use App\Dto\Pipelines\Api\V1\Private\Users\Account\CreatePipelineDto;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\V1\Private\Users\Account\Pipes\Create\AccountPipe as CreateAccountPipe;
use App\Pipelines\V1\Private\Users\Account\Pipes\Create\EmailPipe as CreateEmailPipe;
use App\Pipelines\V1\Private\Users\Account\Pipes\Create\ReferralPipe as CreateReferralPipe;
use App\Pipelines\V1\Private\Users\Account\Pipes\Create\WalletPipe as CreateWalletPipe;

final class AccountPipeline extends AbstractPipeline
{
    public function create(CreatePipelineDto $dto): array
    {
        return $this->pipeline([
            CreateAccountPipe::class,
            CreateEmailPipe::class,
            CreateReferralPipe::class,
            CreateWalletPipe::class,
        ], $dto);
    }
}
