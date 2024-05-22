<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\Referrals;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\ReferralPipelineDto;
use App\Dto\Utils\ApollopaymentApi\CreateAsyncWithdrawalDto;
use App\Exceptions\Pipelines\V1\Billing\WithdrawalNotPossibleException;
use App\Pipelines\PipeInterface;
use App\Services\Utils\ApollopaymentApiService;
use Closure;

final class ApollopaymentWithdrawalPipe implements PipeInterface
{
    public function __construct(
        private readonly ApollopaymentApiService $apollopaymentApiService,
    )
    {
    }

    /**
     * @param ReferralPipelineDto|DtoInterface $dto
     * @param Closure $next
     * @return DtoInterface
     */
    public function handle(ReferralPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        try {
            $feeToken = $dto->getApollopaymentWithdrawalFeeToken();
            $payment = $dto->getPayment();
            $wallet = $dto->getWallet();

            $createAsyncWithdrawalDto = CreateAsyncWithdrawalDto::fromArray([
                'advancedBalanceId' => env('APOLLO_PAYMENT_ADVANCED_BALANCE_ID'),
                'addressId' => env('APOLLO_PAYMENT_BASIC_WALLET_POLYGON_USDT_ADDRESS_ID'),
                'amount' => $payment->getReferralAmount(),
                'address' => $wallet->getWithdrawalAddress(),
                'feeToken' => $feeToken,
                'webhookUrl' => env('APP_URL') . "/v3/public/billing/withdrawal/webhook-referral/" . $dto->getWithdrawal()->getUuid(),
            ]);

            $this->apollopaymentApiService->createAsyncWithdrawal($createAsyncWithdrawalDto);
        } catch (\Exception $e) {
            throw new WithdrawalNotPossibleException($e->getMessage());
        }

        return $next($dto);
    }
}
