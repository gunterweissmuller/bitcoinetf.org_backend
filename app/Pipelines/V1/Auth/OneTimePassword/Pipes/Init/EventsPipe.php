<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\OneTimePassword\Pipes\Init;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\OneTimePassword\InitPipelineDto;
use App\Events\V1\Auth\OneTimeLinkEvent;
use App\Pipelines\PipeInterface;
use Closure;

final class EventsPipe implements PipeInterface
{
    public function handle(InitPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        event(new OneTimeLinkEvent($dto->getEmail()));

        return $next($dto);
    }
}
