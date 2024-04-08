<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Withdrawal;

use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\DividendPipelineDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\ReferralCallbackPipelineDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\ReferralPipelineDto;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\Dividends\ApollopaymentWithdrawalCommissionPipe as DividendsApollopaymentWithdrawalCommissionPipe;
use App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\Dividends\ApollopaymentWithdrawalPipe as DividendsApollopaymentWithdrawalPipe;
use App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\Dividends\KafkaPipe;
use App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\Dividends\GfPayoutPipe as DividendsGfPayoutPipe;
use App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\Dividends\GfPullPaymentPipe as DividendsGfPullPaymentPipe;
use App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\Dividends\PaymentPipe as DividendsPaymentPipe;
use App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\Dividends\SendPaymentPipe as DividendsSendPaymentPipe;
use App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\NewCentrifugalPipe;
use App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\Referrals\PaymentPipe as ReferralsPaymentPipe;
use App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\Referrals\SendPaymentPipe as ReferralsSendPaymentPipe;
use App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\ReferralsCallback\FailurePipe as ReferralsCallbackFailurePipe;
use App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\ReferralsCallback\SuccessPipe as ReferralsCallbackSuccessPipe;
use App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\ReferralsCallback\WithdrawalPipe as ReferralsCallbackWithdrawalPipe;
use App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\UpdateCentrifugalPipe;
use App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\WalletPipe as WalletPipe;
use App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\WithdrawalPipe;
use App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\WithdrawalWebhookPipe;

final class WithdrawalPipeline extends AbstractPipeline
{
    public function dividends(DividendPipelineDto $dto): array
    {
        return $this->pipeline([
            WalletPipe::class,
            DividendsPaymentPipe::class,
            WithdrawalPipe::class,
            DividendsGfPullPaymentPipe::class,
            DividendsGfPayoutPipe::class,
            DividendsApollopaymentWithdrawalCommissionPipe::class,
            DividendsApollopaymentWithdrawalPipe::class,
//            NewCentrifugalPipe::class, @fixme-v open after testing on local
//            DividendsSendPaymentPipe::class, @fixme-v open after testing on local
//            KafkaPipe::class, @fixme-v open after testing on local
        ], $dto);
    }

    public function referrals(ReferralPipelineDto $dto): array
    {
        return $this->pipeline([
            WalletPipe::class,
            ReferralsPaymentPipe::class,
            WithdrawalPipe::class,
            ReferralsSendPaymentPipe::class,
            NewCentrifugalPipe::class,
        ], $dto);
    }

    public function dividendsCallback($dto): array
    {
        return $this->pipeline([
            UpdateCentrifugalPipe::class,
        ], $dto);
    }

    //@fixme add apollo payment webhook here, add webhook in WithdrawalController
    public function apolloWithdrawalWebhook(DividendPipelineDto $dto): array
    {
        return $this->pipeline([
            WithdrawalWebhookPipe::class,
           // UpdateCentrifugalPipe::class, @fixme-v open after testing on local
        ], $dto);
    }

    public function referralsCallback(ReferralCallbackPipelineDto $dto): array
    {
        return $this->pipeline([
            ReferralsCallbackWithdrawalPipe::class,
            ReferralsCallbackSuccessPipe::class,
            ReferralsCallbackFailurePipe::class,
            UpdateCentrifugalPipe::class,
        ], $dto);
    }
}
