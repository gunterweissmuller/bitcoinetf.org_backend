<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Kyc\Screen\Pipes\All;

use App\Dto\DtoInterface;
use App\Dto\Models\Kyc\ScreenDto;
use App\Dto\Pipelines\Api\V1\Public\Kyc\Screen\AllPipelineDto;
use App\Enums\Kyc\Form\StatusEnum as FormStatusEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Kyc\FormService;
use App\Services\Api\V1\Kyc\ScreenService;
use App\Services\Api\V1\Kyc\SessionService;
use Closure;

final class ScreenPipe implements PipeInterface
{
    public function __construct(
        private readonly FormService $formService,
        private readonly ScreenService $screenService,
        private readonly SessionService $sessionService,
    ) {
    }

    public function handle(AllPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $output = [
            'total' => 0,
            'screens' => [],
        ];

        if ($form = $this->formService->get([
            'uuid' => $dto->getForm()->getUuid(),
            'status' => FormStatusEnum::Enabled->value,
        ])) {
            $screens = $this->screenService->all([
                'form_uuid' => $form->getUuid(),
            ]);

            $session = $this->sessionService->get([
                'form_uuid' => $form->getUuid(),
                'account_uuid' => $dto->getAccount()->getUuid(),
            ]);

            if ($screens) {
                /** @var ScreenDto $screen */
                foreach ($screens as $screen) {
                    $output['screens'][] = [
                        'uuid' => $screen->getUuid(),
                        'title' => $screen->getTitle(),
                        'last' => ($screen->getUuid() == $session?->getCurrentScreenUuid()),
                        'order' => $screen->getSort(),
                    ];
                }
            }

            $output['total'] = $output['screens'] ? count($output['screens']) : 0;
        }

        $dto->setOutput($output);

        return $next($dto);
    }
}
