<?php

namespace App\Listeners\V1\Auth;

use App\Events\V1\Auth\NewUserPasswordEvent;
use App\Events\V1\Auth\NewUserResendPasswordEvent;
use App\Jobs\V1\Auth\SendPasswordMailJob;
use App\Services\Api\V1\Users\AccountService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class NewUserSendPassword implements ShouldQueue
{
    public function __construct(
        private readonly AccountService $accountService,
    )
    {
    }

    public function handle(NewUserPasswordEvent|NewUserResendPasswordEvent $event): void
    {
        $accountUuid = $event->getAccount()->getUuid();
        $randomPassword = Str::random();
        $this->accountService->update(['uuid' => $accountUuid], ['password' => Hash::make($randomPassword)]);

        dispatch(new SendPasswordMailJob($accountUuid, $event->getEmail()->getEmail(), $randomPassword));
    }
}
