<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\Pages\SectionTemplate;

use App\Http\Requests\AbstractRequest;
use App\Dto\Models\Pages\SectionTemplateDto;
use App\Dto\Pipelines\Api\V1\Private\Pages\Section\SectionTemplatePipelineDto;

final class UpdateRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'name' => 'string|min:2|max:250',
            'symbol' => 'string|min:2|max:250',
            'data' => 'array',
            'files_uuids' => [
                'array',
            ],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): SectionTemplatePipelineDto
    {
        $data = $this->only([
            'name',
            'data',
            'symbol',
            'files_uuids',
        ]);

        return new SectionTemplatePipelineDto(
            SectionTemplateDto::fromArray($data),
            $data['files_uuids'] ?? null,
        );
    }
}
