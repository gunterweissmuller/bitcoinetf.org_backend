<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\Init;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitPipelineDto;
use App\Events\V1\Auth\NewUserPasswordEvent;
use App\Pipelines\PipeInterface;
use Closure;

final class UserPasswordMailEventPipe implements PipeInterface
{

    /**
     * @param InitPipelineDto|DtoInterface $dto
     * @param Closure $next
     * @return DtoInterface
     */
    public function handle(InitPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        event(new NewUserPasswordEvent($dto->getAccount(), $dto->getEmail()));
        return $next($dto);
    }
}
