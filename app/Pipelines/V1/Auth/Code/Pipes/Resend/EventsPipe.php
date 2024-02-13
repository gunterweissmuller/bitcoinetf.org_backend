<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Code\Pipes\Resend;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitPipelineDto;
use App\Events\V1\Auth\ResendCodeEvent;
use App\Pipelines\PipeInterface;
use Closure;

final class EventsPipe implements PipeInterface
{
    public function handle(InitPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        event(new ResendCodeEvent($dto->getAccount(), $dto->getEmail()));

        return $next($dto);
    }
}
