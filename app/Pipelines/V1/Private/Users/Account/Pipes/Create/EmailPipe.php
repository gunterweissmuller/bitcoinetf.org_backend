<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\Users\Account\Pipes\Create;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Private\Users\Account\CreatePipelineDto;
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

    public function handle(DtoInterface|CreatePipelineDto $dto, Closure $next): DtoInterface
    {
        $account = $dto->getAccount();

        $email = $dto->getEmail();
        $email->setAccountUuid($account->getUuid());
        $email->setStatus(StatusEnum::Enabled->value);

        $dto->setEmail($this->emailService->create($email));

        return $next($dto);
    }
}
