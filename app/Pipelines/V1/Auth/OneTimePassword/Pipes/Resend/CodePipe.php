<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\OneTimePassword\Pipes\Resend;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\OneTimePassword\ResendPipelineDto;
use App\Enums\Auth\Code\StatusEnum;
use App\Enums\Auth\Code\TypeEnum;
use App\Exceptions\Pipelines\V1\Auth\CodeCannotResubmittedException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Auth\CodeService;
use Carbon\Carbon;
use Closure;

final class CodePipe implements PipeInterface
{
    public function __construct(
        private readonly CodeService $codeService
    ) {
    }

    public function handle(ResendPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($lastCode = $this->codeService->get([
            'account_uuid' => $dto->getEmail()->getAccountUuid(),
            'type' => TypeEnum::OneTimePassword->value,
            'status' => StatusEnum::Unused->value,
        ])) {
            if (Carbon::parse($lastCode->getCreatedAt())->diffInMinutes(Carbon::now()) <= 5) {
                throw new CodeCannotResubmittedException();
            }
        }

        $this->codeService->update([
            'account_uuid' => $dto->getEmail()->getAccountUuid(),
            'type' => TypeEnum::OneTimePassword->value,
            'status' => StatusEnum::Unused->value,
        ], [
            'status' => StatusEnum::Expired->value,
        ]);

        return $next($dto);
    }
}
