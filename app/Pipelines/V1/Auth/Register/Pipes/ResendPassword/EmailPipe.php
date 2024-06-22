<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\ResendPassword;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\ResendPasswordPipelineDto;
use App\Enums\Users\Email\StatusEnum;
use App\Exceptions\Pipelines\V1\Auth\EmailNotFoundException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\EmailService;
use Closure;

final class EmailPipe implements PipeInterface
{
    public function __construct(
        private readonly EmailService $emailService
    )
    {
    }

    /**
     * @param ResendPasswordPipelineDto|DtoInterface $dto
     * @param Closure $next
     * @return DtoInterface
     */
    public function handle(ResendPasswordPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $email = $dto->getEmail();
        $email->setStatus(StatusEnum::AwaitConfirm->value);

        if ($email = $this->emailService->get(array_filter($email->toArray()))) {
            $dto->setEmail($email);
        } else {
            throw new EmailNotFoundException();
        }

        return $next($dto);
    }
}
