<?php

declare(strict_types=1);

namespace App\Enums\Auth\Code;

use App\Enums\InteractWithEnum;

enum TypeEnum: string
{
    use InteractWithEnum;

    case Registration = 'registration';

    case PasswordRecovery = 'password-recovery';
}
