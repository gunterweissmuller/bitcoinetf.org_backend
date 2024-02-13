<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Code\Pipes\Check;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Code\CheckPipelineDto;
use App\Enums\Auth\Code\StatusEnum;
use App\Enums\Auth\Code\TypeEnum;
use App\Exceptions\Pipelines\V1\Auth\IncorrectCodeException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Auth\CodeService;
use Closure;

final class CodePipe implements PipeInterface
{
    public function __construct(
        private readonly CodeService $codeService
    ) {
    }

    public function handle(CheckPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $code = $dto->getCode();
        $code->setAccountUuid($dto->getEmail()->getAccountUuid());
        $code->setType(TypeEnum::Registration->value);
        $code->setStatus(StatusEnum::Unused->value);

        if (!$this->codeService->get(array_filter($code->toArray()))) {
            throw new IncorrectCodeException();
        }

        return $next($dto);
    }
}
