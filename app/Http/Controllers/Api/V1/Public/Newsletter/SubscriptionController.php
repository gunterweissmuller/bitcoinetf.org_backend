<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Newsletter;

use App\Http\Requests\Api\V1\Public\Newsletter\Subscription\SubscribeRequest;
use App\Pipelines\V1\Public\Newsletter\SubscribePipeline;
use Illuminate\Http\JsonResponse;
use MailchimpMarketing\ApiClient;

final class SubscriptionController
{
    /**
     * @param SubscribePipeline $pipeline
     */
    public function __construct(
        private readonly SubscribePipeline $pipeline,
    )
    {
    }

    /**
     * @param SubscribeRequest $request
     * @return JsonResponse
     */
    public function subscribe(SubscribeRequest $request): JsonResponse
    {
        [$dto, $e] = $this->pipeline->subscribe($request->dto());

        $mailchimp = new ApiClient();

        $mailchimp->setConfig([
            'apiKey' => env('MAILCHIMP_API_KEY'),
            'server' => env('MAILCHIMP_SERVER_PREFIX'),
        ]);

        $mailchimp->lists->addListMember(env('MAILCHIMP_LIST_ID'), [
            'email_address' => $dto->getEmail(),
            'status' => 'subscribed',
        ]);

        return response()->json();
    }
}
