<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Recovery\Pipes\Init;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Recovery\InitPipelineDto;
use App\Events\V1\Auth\NewRecoveryEvent;
use App\Pipelines\PipeInterface;
use Closure;

final class EventsPipe implements PipeInterface
{
    public function handle(InitPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        event(new NewRecoveryEvent($dto->getEmail()));

        return $next($dto);
    }
}
