<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\Pipes\Callback;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\CallbackPipelineDto;
use App\Exceptions\Utils\Merchant001\Merchant001UnavailableException;
use App\Pipelines\PipeInterface;
use Closure;

final readonly class ValidatePipe implements PipeInterface
{
    public function __construct()
    {
    }

    public function handle(CallbackPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($dto->getTransaction() == null) {
            throw new Merchant001UnavailableException();
        }

        $transaction = $dto->getTransaction();
        $signatures = explode('.', $transaction->getSignature());
        $payload = json_decode(base64_decode($signatures[1]), true);

        if ($payload['id'] != $transaction->getId() && $payload['apiKey'] != env('MERCHANT001_API_TOKEN')) {
            throw new Merchant001UnavailableException();
        }

        if ($transaction->getStatus() == 'FAILED' || $transaction->getStatus() == 'EXPIRED' || $transaction->getStatus() == 'CANCELED') {
            $dto->setStatus('failed');
        }

        if ($transaction->getStatus() == 'CONFIRMED') {
            $dto->setStatus('success');
        }

        return $next($dto);
    }
}
