<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Referral\Invite\Pipes\Apply;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Referral\Invite\ApplyPipelineDto;
use App\Enums\Referrals\Code\StatusEnum;
use App\Exceptions\Pipelines\V1\Referral\CodeNotFoundException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Referrals\CodeService;
use Closure;

final readonly class CodePipe implements PipeInterface
{
    public function __construct(
        private CodeService $codeService,
    ) {
    }

    public function handle(ApplyPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($code = $this->codeService->get([
            'code' => $dto->getCode()->getCode(),
            'status' => StatusEnum::Enabled->value,
            ['account_uuid', '!=', $dto->getInvite()->getAccountUuid()],
        ])) {
            $dto->setCode($code);
        } else {
            throw new CodeNotFoundException();
        }

        return $next($dto);
    }
}
