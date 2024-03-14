<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\Settings\Global;

use App\Models\Settings\GlobalModel;
use App\Dto\Models\Settings\GlobalDto;
use App\Http\Requests\AbstractRequest;
use App\Enums\Settings\Global\TypeEnum;
use App\Exceptions\Pipelines\V1\Settings\GlobalSymbolNotExistsException;

final class UpdateRequest extends AbstractRequest
{
    public function rules(): array
    {
        $model = GlobalModel::query()->where(['symbol' => $this->request->get('symbol')])->first();

        if (is_null($model)) {
            throw new GlobalSymbolNotExistsException();
        }

        $globalDto = GlobalDto::fromArray($model->toArray());

        return match ($globalDto->getType()) {
            TypeEnum::BOOLEAN->value => [
                'symbol' => 'required|string',
                'value' => 'required|boolean',
            ],
            TypeEnum::FLOAT->value => [
                'symbol' => 'required|string',
                'value' => 'required|numeric',
            ],
            TypeEnum::INTEGER->value => [
                'symbol' => 'required|string',
                'value' => 'required|integer',
            ],
            default => [
                'symbol' => 'required|string',
                'value' => 'required|string',
            ],
        };
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): GlobalDto
    {
        $model = GlobalModel::query()->where(['symbol' => $this->request->get('symbol')])->first();

        if (is_null($model)) {
            throw new GlobalSymbolNotExistsException();
        }

        $globalDto = GlobalDto::fromArray($model->toArray());

        return GlobalDto::fromArray([
            ...$this->only([
                'symbol',
                'value',
            ]),
            'type' => $globalDto->getType(),
        ]);
    }
}
