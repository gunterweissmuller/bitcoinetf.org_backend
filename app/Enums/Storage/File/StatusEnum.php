<?php

declare(strict_types=1);

namespace App\Enums\Storage\File;

use App\Enums\InteractWithEnum;

enum StatusEnum: string
{
    use InteractWithEnum;

    case Dispatching = 'dispatching';

    case Active = 'active';

    case Deleting = 'deleting';

    case Deleted = 'deleted';
}
