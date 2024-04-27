<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Login\Pipes\LoginOneTimePass;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginOneTimePasswordPipelineDto;
use App\Enums\Auth\Code\StatusEnum;
use App\Enums\Auth\Code\TypeEnum;
use App\Exceptions\Pipelines\V1\Auth\IncorrectCodeException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Auth\CodeService;
use Carbon\Carbon;
use Closure;

final class CodePipe implements PipeInterface
{
    public function __construct(
        private readonly CodeService $codeService,
    ) {
    }

    public function handle(LoginOneTimePasswordPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $code = $dto->getCode();
        $code->setAccountUuid($dto->getEmail()->getAccountUuid());
        $code->setType(TypeEnum::OneTimePassword->value);
        $code->setStatus(StatusEnum::Unused->value);

        if ($code = $this->codeService->get(array_filter($code->toArray()))) {
            $this->codeService->update([
                'uuid' => $code->getUuid(),
            ], [
                'status' => StatusEnum::Used->value,
                'revoked_at' => Carbon::now()->toDateTimeString(),
            ]);

            $dto->setCode($code);
        } else {
            throw new IncorrectCodeException();
        }

        return $next($dto);
    }
}
