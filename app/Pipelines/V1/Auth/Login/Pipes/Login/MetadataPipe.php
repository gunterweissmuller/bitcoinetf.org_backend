<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Login\Pipes\Login;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginApplePipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginFacebookPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginGooglePipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginMetamaskPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginTelegramPipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\MetadataService;
use Closure;
use Illuminate\Support\Facades\Log;
use Throwable;

final class MetadataPipe implements PipeInterface
{
    public function __construct(
        private readonly MetadataService $metadataService,
    )
    {
    }

    public function handle(LoginPipelineDto|LoginGooglePipelineDto|LoginMetamaskPipelineDto|LoginApplePipelineDto|LoginTelegramPipelineDto|LoginFacebookPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        try {
            $metadataDto = $dto->getMetadata();
            $metadataDto->setAccountUuid($dto->getAccount()->getUuid());

            if (!$this->metadataService->get(array_filter($metadataDto->toArray()))) {
                $this->metadataService->create($dto->getMetadata());
            }
        } catch (Throwable $e) {
            Log::warning('Account Metadata (login) Warring: could not create data ' . $e->getMessage());
        }

        return $next($dto);
    }
}
