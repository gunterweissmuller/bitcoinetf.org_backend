<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\Confirm;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmApplePipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmFacebookPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmGooglePipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmMetamaskPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmTelegramPipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\MetadataService;
use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

final class MetadataPipe implements PipeInterface
{
    public function __construct(
        private readonly MetadataService $metadataService,
    )
    {
    }

    public function handle(ConfirmPipelineDto|ConfirmTelegramPipelineDto|ConfirmApplePipelineDto|ConfirmMetamaskPipelineDto|ConfirmGooglePipelineDto|ConfirmFacebookPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        try {
            $metadataDto = $dto->getMetadata();

            if ($metadataDto->getIpv4Address()) {
                $metadataDto->setAccountUuid($dto->getAccount()->getUuid());

                $response = Http::baseUrl(env('CHECK_IP_HOST'))->get("/" . $metadataDto->getIpv4Address());
                if ($response->ok()) {
                    $body = $response->json();
                    $userInfo = json_encode([
                        'Country' => $body['Country']['ISOCode'],
                        'City' => $body['City']['Names']['en'],
                    ]);
                    $metadataDto->setLocation($userInfo);
                } else {
                    Log::warning('Account Metadata (registration confirm) Warring: could not check location ' . $response->body());
                }

                if (!$this->metadataService->get(array_filter($metadataDto->toArray()))) {
                    $this->metadataService->create($dto->getMetadata());
                }
            }
        } catch (Throwable $e) {
            Log::warning('Account Metadata (registration confirm) Warring: could not create data ' . $e->getMessage());
        }

        return $next($dto);
    }
}
