<?php

declare(strict_types=1);

namespace app\Pipelines\V1\Auth\Register\Pipes\Confirm;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmPipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\AccountService;
use Closure;
use Exception;
use Illuminate\Support\Facades\Http;

final readonly class TronWalletPipe implements PipeInterface
{
    public function __construct(
        private AccountService $accountService,
    ) {
    }

    public function handle(ConfirmPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        try {
            $account = $this->accountService->get(['uuid' => $dto->getEmail()->getAccountUuid()]);

            if (!$account->getTronWallet()) {
                $response = Http::baseUrl(env('PAYMENT_HOST'))
                    ->withHeaders([
                        'Authorization' => 'Bearer '.env('PAYMENT_API_KEY'),
                    ])
                    ->post('/v2/users/create', [
                        'account_uuid' => $dto->getAccount()->getUuid(),
                    ])
                    ->throw()
                    ->json();

                $account->setTronWallet($response['wallet_uuid']);
                $this->accountService->update([
                    'uuid' => $account->getUuid(),
                ], [
                    'tron_wallet' => $response['wallet_uuid'] ?? null,
                ]);
                $dto->setAccount($account);
            }
        } catch (Exception $e) {
            //throw new ReplenishmentNotAvailableException();
        }

        return $next($dto);
    }
}
