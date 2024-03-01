<?php

declare(strict_types=1);

namespace App\Enums\Auth\AuthType;

use App\Enums\InteractWithEnum;

enum StatusEnum: string
{
    use InteractWithEnum;

    case Registration = 'registration';

    case Login = 'login';
}
