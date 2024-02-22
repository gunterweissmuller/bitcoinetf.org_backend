<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\Referrals;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\ReferralPipelineDto;
use App\Exceptions\Pipelines\V1\Billing\WithdrawalNotPossibleException;
use App\Pipelines\PipeInterface;
use Closure;
use Exception;
use Illuminate\Support\Facades\Http;

final readonly class SendPaymentPipe implements PipeInterface
{
    public function handle(ReferralPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $wallet = $dto->getWallet();
        $withdrawal = $dto->getWithdrawal();

        try {
            Http::baseUrl(env('PAYMENT_HOST'))
                ->withHeaders([
                    'Authorization' => 'Bearer '.env('PAYMENT_API_KEY'),
                ])
                ->post('/payments/withdraw', [
                    'uuid' => $withdrawal->getUuid(),
                    'network' => 'tron',
                    'token' => 'usdt',
                    'amount' => $withdrawal->getTotalAmount(),
                    'pubkey' => $wallet->getWithdrawalAddress(),
                ])
                ->throw()
                ->json();
        } catch (Exception $exception) {
            throw new WithdrawalNotPossibleException();
        }

        return $next($dto);
    }
}
