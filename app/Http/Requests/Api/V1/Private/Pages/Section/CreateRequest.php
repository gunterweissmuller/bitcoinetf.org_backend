<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\Pages\Section;

use Illuminate\Validation\Rule;
use App\Dto\Models\Pages\SectionDto;
use App\Enums\Pages\Pages\StatusEnum;
use App\Http\Requests\AbstractRequest;
use App\Dto\Pipelines\Api\V1\Private\Pages\Section\SectionPipelineDto;

final class CreateRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'language_id' => 'required|integer',
            'name' => 'required|string|min:2|max:250',
            'status' => [
                'required',
                'string',
                Rule::in(array_column(StatusEnum::cases(), 'value')),
            ],
            'number' => 'required|integer',
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

    public function dto(): SectionPipelineDto
    {
        $data = $this->only([
            'language_id',
            'name',
            'status',
            'number',
            'data',
            'files_uuids',
        ]);

        return new SectionPipelineDto(
            SectionDto::fromArray($data),
            $data['files_uuids'] ?? null,
        );
    }
}
