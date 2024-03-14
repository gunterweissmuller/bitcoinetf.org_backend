<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\Confirm;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmPipelineDto;
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

    public function handle(ConfirmPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($email = $this->emailService->get(array_filter($dto->getEmail()->toArray()))) {
            $this->emailService->update([
                'uuid' => $email->getUuid(),
            ], [
                'status' => StatusEnum::Enabled->value,
            ]);

            $dto->setEmail($email);
        } else {
            throw new EmailNotFoundException();
        }

        return $next($dto);
    }
}
