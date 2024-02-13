<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Public\Storage\File;

use App\Dto\Models\Storage\FileDto;
use App\Dto\Pipelines\Api\V1\Public\Storage\File\UploadPipelineDto;
use App\Enums\Storage\File\TypeEnum;
use App\Http\Requests\AbstractRequest;
use Illuminate\Validation\Rules\Enum;

final class UploadRequest extends AbstractRequest
{
    public function rules(): array
    {
        $type = $this->get('type') ?? null;

        if (!$type) {
            return [
                'type' => ['required', new Enum(TypeEnum::class)],
            ];
        }

        return [
            'type' => ['required', new Enum(TypeEnum::class)],
            'file' => ['required', 'mimes:'.implode(',', TypeEnum::getExtensions($type))],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): UploadPipelineDto
    {
        return new UploadPipelineDto(
            $this->file,
            FileDto::fromArray([
                'extension' => $this->file()['file']->extension(),
                'type' => $this->get('type'),
            ])
        );
    }
}
