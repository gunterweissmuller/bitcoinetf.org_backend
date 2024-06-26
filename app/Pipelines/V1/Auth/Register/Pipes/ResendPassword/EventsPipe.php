<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\ResendPassword;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\ResendPasswordPipelineDto;
use App\Events\V1\Auth\NewUserResendPasswordEvent;
use App\Pipelines\PipeInterface;
use Closure;

final class EventsPipe implements PipeInterface
{
    /**
     * @param ResendPasswordPipelineDto|DtoInterface $dto
     * @param Closure $next
     * @return DtoInterface
     */
    public function handle(ResendPasswordPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        event(new NewUserResendPasswordEvent($dto->getAccount(), $dto->getEmail()));
        return $next($dto);
    }
}
