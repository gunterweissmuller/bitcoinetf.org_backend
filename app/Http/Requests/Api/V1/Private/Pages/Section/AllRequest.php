<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\Pages\Section;

use App\Dto\Models\Pages\SectionDto;
use App\Http\Requests\AbstractRequest;

final class AllRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'language_id' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): SectionDto
    {
        return SectionDto::fromArray([
            'language_id' => (int) $this->get('language_id'),
        ]);
    }
}
