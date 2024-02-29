<?php

declare(strict_types=1);

namespace App\Enums\Pap\Event;

use App\Enums\InteractWithEnum;

enum EventEnum: string
{
    use InteractWithEnum;

    case Signup = 'signup';

    case Sale = 'sale';
}
