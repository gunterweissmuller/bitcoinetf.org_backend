<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Public\Kyc\Screen;

use App\Dto\Models\Kyc\FieldDto;
use App\Dto\Models\Kyc\FieldOptionDto;
use App\Dto\Models\Kyc\ScreenDto;
use App\Dto\Models\Kyc\SessionResultDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Pipelines\Api\V1\Public\Kyc\Screen\SavePipelineDto;
use App\Enums\Kyc\Field\TypeEnum;
use App\Http\Requests\AbstractRequest;
use App\Rules\DateAgeValidator;
use App\Rules\FullAgeValidator;
use App\Rules\TaxResidenceForbiddenValidator;
use App\Services\Api\V1\Kyc\FieldOptionService;
use App\Services\Api\V1\Kyc\FieldService;
use Nette\Utils\Type;

final class SaveRequest extends AbstractRequest
{
    private array $fields = [];

    public function rules(): array
    {
        if ($uuid = $this->get('uuid')) {
            return $this->generateDynamicRules($uuid);
        } else {
            return [
                'uuid' => ['required', 'uuid'],
            ];
        }
    }

    public function attributes(): array
    {
        return $this->generateAttributes($this->get('uuid'));
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): SavePipelineDto
    {
        $account = $this->payload();

        return SavePipelineDto::fromArray([
            'account' => AccountDto::fromArray($account->toArray()),
            'screen' => ScreenDto::fromArray([
                'uuid' => $this->get('uuid'),
            ]),
            'session_result' => SessionResultDto::fromArray([
                'screen_uuid' => $this->get('uuid'),
                'data' => $this->only($this->fields),
            ]),
        ]);
    }

    private function generateAttributes(string $uuid): array
    {
        /** @var FieldService $fieldService */
        $fieldService = app(FieldService::class);

        $attributes = [];
        if ($fields = $fieldService->all(['screen_uuid' => $uuid])) {
            foreach ($fields as $field) {
                if ($field->getLabel()) {
                    $attributes[$field->getName()] = strtolower($field->getLabel());
                }
            }
        }

        return $attributes;
    }

    private function generateDynamicRules(string $uuid): array
    {
        /** @var FieldService $fieldService */
        $fieldService = app(FieldService::class);
        /** @var FieldOptionService $fieldOptionService */
        $fieldOptionService = app(FieldOptionService::class);

        $rules = [
            'uuid' => ['required', 'uuid'],
        ];

        if ($fields = $fieldService->all(['screen_uuid' => $uuid])) {
            /** @var FieldDto $field */
            foreach ($fields as $field) {
                $options = [];

                if ($field->getRequired()) {
                    $options = [...$options, 'required'];
                }

                if ($field->getType() == TypeEnum::Text->value) {
                    $options = [...$options, 'string'];
                } elseif ($field->getType() == TypeEnum::Date->value) {
                    $options = [...$options, 'string', 'date_format:Y-m-d'];
                } elseif ($field->getType() == TypeEnum::Select->value || $field->getType() == TypeEnum::RadioGroup->value) {
                    $enums = [];

                    if ($field->getName() == 'state') {
                        $file = storage_path('/kyc/countries.json');
                        $countries = collect(json_decode(file_get_contents($file), true));

                        if ($country = $countries->where('value', $this->get('country'))->first()) {
                            foreach ($country['states'] as $state) {
                                $enums[] = $state['value'];
                            }
                        }
                    } else {
                        if ($fieldOptions = $fieldOptionService->all(['field_uuid' => $field->getUuid()])) {
                            /** @var FieldOptionDto $option */
                            foreach ($fieldOptions as $fieldOption) {
                                $enums[] = $fieldOption->getValue();
                            }
                        }
                    }

                    if (count($enums) > 0) {
                        $options = [...$options, 'string', 'in:'.implode(',', $enums)];
                    } else {
                        $options = ['nullable', 'string'];
                    }
                } elseif ($field->getType() == TypeEnum::File->value) {
                    $rules[$field->getName()] = [...$options, 'array'];
                    $rules[$field->getName().'.*'] = [...$options, 'uuid', 'exists:App\Models\Storage\File,uuid'];
                } elseif ($field->getType() == TypeEnum::Checkbox->value) {
                    $options = [...$options, 'accepted'];
                }

                if (!in_array($field->getName(), $this->fields)) {
                    $this->fields[] = $field->getName();
                }

                if ($field->getType() != TypeEnum::File->value) {
                    $rules[$field->getName()] = $options;
                }

                if ($field->getName() == 'tax-residence') {
                    $rules[$field->getName()] = [...$options, new TaxResidenceForbiddenValidator()];
                }

                if ($field->getName() == 'full-name') {
                    $rules[$field->getName()] = [...$options, 'regex:/^([a-zA-z-]{3,})\s([a-zA-z-]{3,})$/'];
                }

                if ($field->getName() == 'date-of-birth') {
                    $rules[$field->getName()] = [...$options, new DateAgeValidator(), new FullAgeValidator()];
                }
            }
        }

        return $rules;
    }
}
