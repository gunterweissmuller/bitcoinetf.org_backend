<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Recovery\Pipes\Init;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Recovery\InitPipelineDto;
use App\Enums\Users\Email\StatusEnum;
use App\Exceptions\Pipelines\V1\Auth\EmailNotFoundException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\EmailService;
use Closure;

final class EmailPipe implements PipeInterface
{
    public function __construct(
        private readonly EmailService $emailService,
    ) {
    }

    public function handle(InitPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $email = $dto->getEmail();
        $email->setStatus(StatusEnum::Enabled->value);

        if ($email = $this->emailService->get(array_filter($email->toArray()))) {
            $dto->setEmail($email);
        } else {
            throw new EmailNotFoundException();
        }

        return $next($dto);
    }
}
