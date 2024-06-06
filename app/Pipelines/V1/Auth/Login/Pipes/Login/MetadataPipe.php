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
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginWalletConnectPipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\MetadataService;
use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

final class MetadataPipe implements PipeInterface
{
    /**
     * @param MetadataService $metadataService
     */
    public function __construct(
        private readonly MetadataService $metadataService,
    )
    {
    }

    /**
     * @param LoginPipelineDto|LoginGooglePipelineDto|LoginMetamaskPipelineDto|LoginApplePipelineDto|LoginTelegramPipelineDto|LoginFacebookPipelineDto|LoginWalletConnectPipelineDto|DtoInterface $dto
     * @param Closure $next
     * @return DtoInterface
     */
    public function handle(LoginPipelineDto|LoginGooglePipelineDto|LoginMetamaskPipelineDto|LoginApplePipelineDto|LoginTelegramPipelineDto|LoginFacebookPipelineDto|LoginWalletConnectPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
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
                    Log::warning('Account Metadata (login) Warring: could not check location ' . $response->body());
                }

                if (!$this->metadataService->get(array_filter($metadataDto->toArray()))) {
                    $this->metadataService->create($dto->getMetadata());
                }
            }
        } catch (Throwable $e) {
            Log::warning('Account Metadata (login) Warring: could not create data ' . $e->getMessage());
        }

        return $next($dto);
    }
}
