<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\Init;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitPipelineDto;
use App\Events\V1\Users\NewUserEvent;
use App\Pipelines\PipeInterface;
use Closure;

final class UserEventPipe implements PipeInterface
{
    public function handle(InitPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        event(new NewUserEvent($dto->getAccount(), $dto->getEmail()));
        return $next($dto);
    }
}
