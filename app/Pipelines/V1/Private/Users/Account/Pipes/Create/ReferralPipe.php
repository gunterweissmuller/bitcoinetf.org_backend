<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\Users\Account\Pipes\Create;

use App\Dto\DtoInterface;
use App\Dto\Models\Referrals\CodeDto;
use App\Dto\Pipelines\Api\V1\Private\Users\Account\CreatePipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Referrals\CodeService;
use Closure;

final class ReferralPipe implements PipeInterface
{
    public function __construct(
        private readonly CodeService $codeService,
    ) {
    }

    public function handle(DtoInterface|CreatePipelineDto $dto, Closure $next): DtoInterface
    {
        $account = $dto->getAccount();

        $this->codeService->create(CodeDto::fromArray([
            'account_uuid' => $account->getUuid(),
        ]));

        return $next($dto);
    }
}
