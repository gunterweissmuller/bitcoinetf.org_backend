<?php

declare(strict_types=1);

namespace App\Enums\Settings\Global;

use App\Enums\InteractWithEnum;

enum TypeEnum: string
{
    use InteractWithEnum;

    case STRING = 'string';

    case BOOLEAN = 'boolean';

    case FLOAT = 'float';

    case INTEGER = 'integer';
}
