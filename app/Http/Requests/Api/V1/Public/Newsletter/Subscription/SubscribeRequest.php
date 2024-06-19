<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Public\Newsletter\Subscription;

use App\Dto\Models\Newsletter\SubscriptionDto;
use App\Dto\Pipelines\Api\V1\Public\Newsletter\SubscribePipelineDto;
use App\Http\Requests\AbstractRequest;

final class SubscribeRequest extends AbstractRequest
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email:dns'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * @return SubscribePipelineDto
     */
    public function dto(): SubscribePipelineDto
    {
        return SubscribePipelineDto::fromArray([
            'subscription' => SubscriptionDto::fromArray([
                'email' => $this->get('email'),
            ]),
        ]);
    }
}
