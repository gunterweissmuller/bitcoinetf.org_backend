<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Newsletter;

use App\Http\Requests\Api\V1\Public\Newsletter\Subscription\SubscribeRequest;
use Illuminate\Http\JsonResponse;
use MailchimpMarketing\ApiClient;

final class SubscriptionController
{
    public function subscribe(SubscribeRequest $request): JsonResponse
    {
        $mailchimp = new ApiClient();

        $mailchimp->setConfig([
            'apiKey' => env('MAILCHIMP_API_KEY'),
            'server' => env('MAILCHIMP_SERVER_PREFIX'),
        ]);

        $mailchimp->lists->addListMember(env('MAILCHIMP_LIST_ID'), [
            'email_address' => $request->dto()->getEmail(),
            'status' => 'subscribed',
        ]);

        return response()->json();
    }
}
