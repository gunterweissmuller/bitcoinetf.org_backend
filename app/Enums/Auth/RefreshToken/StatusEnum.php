<?php

declare(strict_types=1);

namespace App\Enums\Auth\RefreshToken;

use App\Enums\InteractWithEnum;

enum StatusEnum: string
{
    use InteractWithEnum;

    case Used = 'used';

    case Unused = 'unused';

    case Expired = 'expired';

    case Locked = 'locked';
}
