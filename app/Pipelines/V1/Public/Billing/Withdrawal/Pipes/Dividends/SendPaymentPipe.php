<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\Dividends;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\DividendPipelineDto;
use App\Exceptions\Pipelines\V1\Billing\WithdrawalNotPossibleException;
use App\Pipelines\PipeInterface;
use Closure;
use Exception;
use Illuminate\Support\Facades\Http;
//@fixme check type MethodEnum: BITCOIN_ON_CHAIN or BITCOIN_LIGHTNING
//@fixme how it works

final readonly class SendPaymentPipe implements PipeInterface
{
    public function handle(DividendPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $wallet = $dto->getWallet();
        $withdrawal = $dto->getWithdrawal();

        try {
            Http::baseUrl(env('PAYMENT_HOST'))
                ->withHeaders([
                    'Authorization' => 'Bearer '.env('PAYMENT_API_KEY'),
                ])
                ->post('/v1/withdraw', [
                    'uuid' => $withdrawal->getUuid(),
                    'network' => 'polygon',
                    'token' => 'usdt',
                    'amount' => $withdrawal->getTotalAmount(),
                    'pubkey' => $wallet->getWithdrawalAddress(),
                ])
                ->throw()
                ->json();
        } catch (Exception $exception) {
            throw new WithdrawalNotPossibleException($exception->getMessage());
        }

        return $next($dto);
    }
}
