<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Kyc\Screen\Pipes\Save;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Kyc\Screen\SavePipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Kyc\ScreenService;
use Closure;

final class ScreenPipe implements PipeInterface
{
    public function __construct(
        private readonly ScreenService $screenService,
    ) {
    }

    public function handle(SavePipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $screen = $dto->getScreen();

        if ($screen = $this->screenService->get(['uuid' => array_filter($screen->toArray())])) {
            $dto->setScreen($screen);
        }

        return $next($dto);
    }
}
