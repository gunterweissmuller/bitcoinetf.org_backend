<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Public\Statistic\Dividend;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\DtoInterface;
use App\Http\Requests\AbstractRequest;

final class GetRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'year' => [
                'required',
                'int',
            ],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function year(): int
    {
        return (int)$this->get('year');
    }

    public function dto(): ?DtoInterface
    {
        // TODO: Implement dto() method.
    }
}
