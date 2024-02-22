<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\InitMetamaskAuth;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitMetamaskPipelineDto;
use App\Enums\Users\Email\StatusEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\EmailService;
use Closure;

final class EmailPipe implements PipeInterface
{
    public function __construct(
        private readonly EmailService $emailService,
    ) {
    }

    public function handle(InitMetamaskPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if (!$dto->getIsExistsEmail()) {
            $email = $dto->getEmail();
            $email->setAccountUuid($dto->getAccount()->getUuid());
            $email->setStatus(StatusEnum::AwaitConfirm->value);

            $email = $this->emailService->create($email);
        } else {
            $email = $this->emailService->get(['account_uuid' => $dto->getAccount()->getUuid()]);
        }

        $dto->setEmail($email);

        return $next($dto);
    }
}
