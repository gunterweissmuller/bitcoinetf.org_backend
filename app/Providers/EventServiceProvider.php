<?php

namespace App\Providers;

use App\Events\V1\Auth\NewRecoveryEvent;
use App\Events\V1\Auth\ResendCodeEvent;
use App\Events\V1\Users\NewUserEvent;
use App\Listeners\V1\Auth\NewUserSendVerify;
use App\Listeners\V1\Auth\RecoveryUserSendVerify;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SocialiteProviders\Apple\AppleExtendSocialite;
use SocialiteProviders\Manager\SocialiteWasCalled;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        NewUserEvent::class => [
            NewUserSendVerify::class,
        ],
        ResendCodeEvent::class => [
            NewUserSendVerify::class,
        ],
        NewRecoveryEvent::class => [
            RecoveryUserSendVerify::class,
        ],
        SocialiteWasCalled::class => [
            AppleExtendSocialite::class.'@handle',
        ],
    ];

    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
