<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Recovery\Pipes\Confirm;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Recovery\ConfirmPipelineDto;
use App\Enums\Auth\Code\StatusEnum;
use App\Exceptions\Pipelines\V1\Auth\IncorrectCodeException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Auth\CodeService;
use Closure;

final class CodePipe implements PipeInterface
{
    public function __construct(
        private readonly CodeService $codeService,
    ) {
    }

    public function handle(ConfirmPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $code = $dto->getCode();
        $code->setStatus(StatusEnum::Unused->value);

        if ($code = $this->codeService->get(array_filter($code->toArray()))) {
            $dto->setCode($code);
        } else {
            throw new IncorrectCodeException();
        }

        return $next($dto);
    }
}
