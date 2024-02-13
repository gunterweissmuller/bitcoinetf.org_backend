<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Kyc\Screen\Pipes\Get;

use App\Dto\DtoInterface;
use App\Dto\Models\Kyc\FieldDto;
use App\Dto\Models\Kyc\FieldOptionDto;
use App\Dto\Pipelines\Api\V1\Public\Kyc\Screen\GetPipelineDto;
use App\Enums\Kyc\Field\TypeEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Kyc\FieldOptionService;
use App\Services\Api\V1\Kyc\FieldService;
use App\Services\Api\V1\Kyc\ScreenService;
use Closure;

final class ScreenPipe implements PipeInterface
{
    public function __construct(
        private readonly ScreenService $screenService,
        private readonly FieldService $fieldService,
        private readonly FieldOptionService $fieldOptionService,
    ) {
    }

    public function handle(GetPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $output = [];

        if ($screen = $this->screenService->get(['uuid' => $dto->getScreen()->getUuid()])) {
            $fields = $this->fieldService->all(['screen_uuid' => $screen->getUuid()]);

            $output = [
                'uuid' => $screen->getUuid(),
                'title' => $screen->getTitle(),
                'subtitle' => $screen->getSubtitle(),
                'fields' => [],
            ];

            /** @var FieldDto $field */
            foreach ($fields ?? [] as $i => $field) {
                $output['fields'][$i] = [
                    'name' => $field->getName(),
                    'label' => $field->getLabel(),
                    'type' => $field->getType(),
                    'enums' => $field->getEnums() ? json_decode($field->getEnums(), true) : null,
                    'model' => '',
                ];

                if ($field->getType() == TypeEnum::Select->value || $field->getType() == TypeEnum::RadioGroup->value) {
                    $output['fields'][$i]['options'] = [];

                    if ($field->getName() != 'state') {
                        $options = $this->fieldOptionService->all(['field_uuid' => $field->getUuid()]);

                        /** @var FieldOptionDto $option */
                        foreach ($options ?? [] as $option) {
                            $output['fields'][$i]['options'][] = [
                                'label' => $option->getLabel(),
                                'value' => $option->getValue(),
                            ];
                        }
                    }
                }
            }
        }

        $dto->setOutput($output);

        return $next($dto);
    }
}
