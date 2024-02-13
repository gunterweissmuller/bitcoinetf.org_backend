<?php

declare(strict_types=1);

namespace App\Enums\Auth\Code;

use App\Enums\InteractWithEnum;

enum StatusEnum: string
{
    use InteractWithEnum;

    case Dispatching = 'dispatching';

    case Expired = 'expired';

    case Unused = 'unused';

    case Used = 'used';

    case Locked = 'locked';
}
