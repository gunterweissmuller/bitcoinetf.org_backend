<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\Payout;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\PayoutPipelineDto;
use App\Dto\Utils\ApollopaymentApi\CreateAsyncWithdrawalDto;
use App\Enums\Billing\Withdrawal\MethodEnum;
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
     * @param PayoutPipelineDto|DtoInterface $dto
     * @param Closure $next
     * @return DtoInterface
     */
    public function handle(PayoutPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($dto->getSell()->getMethod() == MethodEnum::POLYGON_USDT->value) {
            try {
                $feeToken = $dto->getApollopaymentWithdrawalFeeToken();
                $sell = $dto->getSell();

                $createAsyncWithdrawalDto = CreateAsyncWithdrawalDto::fromArray([
                    'advancedBalanceId' => env('APOLLO_PAYMENT_ADVANCED_BALANCE_ID'),
                    'addressId' => env('APOLLO_PAYMENT_BASIC_WALLET_POLYGON_USDT_ADDRESS_ID'),
                    'amount' => $sell->getValue(),
                    'address' => $sell->getDestination(),
                    'feeToken' => $feeToken,
                    'webhookUrl' => env('APP_URL') . "/v3/public/billing/withdrawal/webhook-payout/" . $dto->getSell()->getUuid(),
                ]);

                $this->apollopaymentApiService->createAsyncWithdrawal($createAsyncWithdrawalDto);
            } catch (\Exception $e) {
                throw new WithdrawalNotPossibleException($e->getMessage());
            }
        }

        return $next($dto);
    }
}
