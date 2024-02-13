<?php

declare(strict_types=1);

namespace App\Enums\News\Integration;

use App\Enums\InteractWithEnum;

enum StatusEnum: string
{
    use InteractWithEnum;

    case ACTIVE = 'active';

    case DISABLED = 'disabled';
}
