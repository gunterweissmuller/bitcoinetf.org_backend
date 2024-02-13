<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Kyc\Form\Pipes\Get;

use App\Dto\DtoInterface;
use App\Dto\Models\Kyc\FormDto;
use App\Dto\Models\Kyc\SessionDto;
use App\Dto\Pipelines\Api\V1\Public\Kyc\Form\GetPipelineDto;
use App\Enums\Kyc\Form\StatusEnum as FormStatusEnum;
use App\Enums\Kyc\Session\StatusEnum as SessionStatusEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Kyc\FormService;
use App\Services\Api\V1\Kyc\SessionService;
use Closure;

final class FormPipe implements PipeInterface
{
    public function __construct(
        private readonly FormService $formService,
        private readonly SessionService $sessionService,
    ) {
    }

    public function handle(GetPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $forms = $this->formService->all(['status' => FormStatusEnum::Enabled->value]);
        $sessions = $this->sessionService->all(['account_uuid' => $dto->getAccount()->getUuid()]);

        $output = [];
        /** @var FormDto $form */
        foreach ($forms as $form) {
            $session = $this->getSessionByFormUuid($sessions?->toArray(), $form->getUuid());

            $output[] = [
                'uuid' => $form->getUuid(),
                'title' => $form->getTitle(),
                'status' => $session?->getStatus() ?? SessionStatusEnum::New->value,
                'current_screen_uuid' => $session?->getCurrentScreenUuid() ?? null,
            ];
        }

        $dto->setOutput($output);

        return $next($dto);
    }

    private function getSessionByFormUuid(?array $sessions, string $uuid): ?SessionDto
    {
        if ($sessions) {
            /** @var SessionDto $session */
            foreach ($sessions as $session) {
                if ($session->getFormUuid() == $uuid) {
                    return $session;
                }
            }
        }

        return null;
    }
}
