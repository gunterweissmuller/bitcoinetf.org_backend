<?php

namespace App\Providers;

use App\Events\V1\Auth\NewRecoveryEvent;
use App\Events\V1\Auth\NewUserPasswordEvent;
use App\Events\V1\Auth\NewUserResendPasswordEvent;
use App\Events\V1\Auth\OneTimeLinkEvent;
use App\Events\V1\Auth\ResendCodeEvent;
use App\Events\V1\Users\NewUserEvent;
use App\Listeners\V1\Auth\NewUserSendPassword;
use App\Listeners\V1\Auth\NewUserSendVerify;
use App\Listeners\V1\Auth\RecoveryUserSendVerify;
use App\Listeners\V1\Auth\UserOneTimeLinkLoginSendVerify;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SocialiteProviders\Apple\AppleExtendSocialite;
use SocialiteProviders\Manager\SocialiteWasCalled;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        NewUserPasswordEvent::class => [
            NewUserSendPassword::class,
        ],
        NewUserResendPasswordEvent::class => [
            NewUserSendPassword::class,
        ],
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
            AppleExtendSocialite::class . '@handle',
        ],
        OneTimeLinkEvent::class => [
            UserOneTimeLinkLoginSendVerify::class,
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
