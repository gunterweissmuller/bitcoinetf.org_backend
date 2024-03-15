<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\Confirm;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmPipelineDto;
use App\Jobs\V1\Users\SendWelcomeMailJob;
use App\Pipelines\PipeInterface;
use Closure;

final class MailPipe implements PipeInterface
{
    public function __construct()
    {
    }

    public function handle(ConfirmPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        dispatch(new SendWelcomeMailJob($dto->getAccount()->getUuid(), $dto->getEmail()->getEmail()));

        return $next($dto);
    }
}
