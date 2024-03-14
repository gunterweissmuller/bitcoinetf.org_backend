<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Kyc\Screen\Pipes\Save;

use App\Dto\DtoInterface;
use App\Dto\Models\Kyc\SessionFileDTO;
use App\Dto\Pipelines\Api\V1\Public\Kyc\Screen\SavePipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Kyc\SessionFileService;
use Closure;

final class SessionFilePipe implements PipeInterface
{
    public function __construct(
        private readonly SessionFileService $sessionFileService,
    ) {
    }

    public function handle(SavePipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $session = $dto->getSession();
        $sessionResult = $dto->getSessionResult();

        if ($sessionResult) {
            $data = $sessionResult->getData();
            if (isset($data['files_uuid'])) {
                foreach ($data['files_uuid'] as $fileUuid) {
                    $this->sessionFileService->create(SessionFileDTO::fromArray([
                        'session_uuid' => $session->getUuid(),
                        'file_uuid' => $fileUuid,
                    ]));
                }
            }
        }

        return $next($dto);
    }
}
