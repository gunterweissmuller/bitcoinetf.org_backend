<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\Storage\File;

use Illuminate\Validation\Rule;
use App\Dto\Models\Storage\FileDto;
use App\Enums\Storage\File\TypeEnum;
use App\Http\Requests\AbstractRequest;
use App\Enums\Storage\File\ExtensionEnum;
use App\Dto\Pipelines\Api\V1\Private\Storage\File\UploadDto;

final class UploadRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'file' => 'required|mimes:' . implode(',', array_column(ExtensionEnum::cases(), 'value')),
            'type' => [
                'required',
                Rule::in(array_column(TypeEnum::cases(), 'value')),
            ],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): UploadDto
    {
        return new UploadDto(
            $this->file,
            FileDto::fromArray([
                'extension' => $this->file()['file']->extension(),
                'type' => $this->get('type'),
            ])
        );
    }
}
