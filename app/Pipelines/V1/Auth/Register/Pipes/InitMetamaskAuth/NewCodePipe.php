<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\InitMetamaskAuth;

use App\Dto\DtoInterface;
use App\Dto\Models\Referrals\CodeDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitMetamaskPipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Referrals\CodeService;
use Closure;

final class NewCodePipe implements PipeInterface
{
    public function __construct(
        private readonly CodeService $codeService,
    ) {
    }

    public function handle(InitMetamaskPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $account = $dto->getAccount();

        if (!$dto->getIsExistsEmail() && !$dto->getIsExistsWallet()) {
            $dto->setNewCode($this->codeService->create(CodeDto::fromArray([
                'account_uuid' => $account->getUuid(),
            ])));
        } else {
            $dto->setNewCode($this->codeService->get([
                'account_uuid' => $account->getUuid(),
            ]));
        }

        return $next($dto);
    }
}
