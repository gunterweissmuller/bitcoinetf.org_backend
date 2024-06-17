<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Recovery\Pipes\Confirm;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Recovery\ConfirmPipelineDto;
use App\Models\Auth\RefreshToken;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\AccountService;
use Closure;
use Illuminate\Support\Carbon;

final class ClearSessionsPipe implements PipeInterface
{
    public function __construct(
        private readonly AccountService $accountService,
    ) {
    }

    public function handle(ConfirmPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($account = $this->accountService->get(['uuid' => $dto->getCode()->getAccountUuid()])) {
            RefreshToken::whereAccountUuid($account->getUuid())->update(['revoked_at' => Carbon::now()]);
        }

        return $next($dto);
    }
}
