<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\Referrals\Code;

use App\Dto\Models\Referrals\CodeDto;
use App\Enums\Referrals\Code\StatusEnum;
use App\Http\Requests\AbstractRequest;
use Illuminate\Validation\Rules\Enum;

final class UpdateRequest extends AbstractRequest
{
    public function rules(): array
    {
        $uuid = request()->route('uuid');

        return [
            'code' => ['required', 'string', 'unique:App\Models\Referrals\Code,code,'.$uuid],
            'status' => ['required', 'string', new Enum(StatusEnum::class)],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): CodeDto
    {
        return CodeDto::fromArray([
            'code' => strtoupper($this->get('code')),
            'status' => $this->get('status'),
        ]);
    }
}
