<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\InitMetamaskAuth;

use App\Dto\DtoInterface;
use App\Dto\Models\Referrals\InviteDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitMetamaskPipelineDto;
use App\Enums\Referrals\Code\StatusEnum;
use App\Exceptions\Pipelines\V1\Auth\IncorrectCodeException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Referrals\CodeService;
use App\Services\Api\V1\Referrals\InviteService;
use Closure;

final class InvitePipe implements PipeInterface
{
    public function __construct(
        private readonly CodeService $codeService,
        private readonly InviteService $inviteService,
    ) {
    }

    public function handle(InitMetamaskPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $account = $dto->getAccount();
        $refCode = $dto->getRefCode();

        if (!$dto->getIsExistsEmail() && !$dto->getIsExistsWallet()) {
            if (!is_null($refCode->getCode())) {
                $refCode->setStatus(StatusEnum::Enabled->value);

                if ($refCode = $this->codeService->get([
                    'code' => $refCode->getCode(),
                    'status' => StatusEnum::Enabled->value,
                ])) {
                    $dto->setRefCode($refCode);
                    $dto->setInvite($this->inviteService->create(InviteDto::fromArray([
                        'code_uuid' => $refCode->getUuid(),
                        'account_uuid' => $account->getUuid(),
                    ])));
                } else {
                    throw new IncorrectCodeException();
                }
            }
        } else {
            if (!is_null($refCode->getCode())) {
                if ($refCode = $this->codeService->get([
                    'code' => $refCode->getCode(),
                    'status' => StatusEnum::Enabled->value,
                ])) {
                    $dto->setRefCode($refCode);
                    $dto->setInvite($this->inviteService->create(InviteDto::fromArray([
                        'code_uuid' => $refCode->getUuid(),
                        'account_uuid' => $account->getUuid(),
                    ])));
                } else {
                    throw new IncorrectCodeException();
                }
            } else {
                $this->inviteService->delete([
                    'account_uuid' => $account->getUuid(),
                ]);
                $dto->setRefCode(null);
                $dto->setInvite(null);
            }
        }

        return $next($dto);
    }
}
