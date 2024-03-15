<?php

declare(strict_types=1);

namespace App\Enums\Pages\Pages;

enum StatusEnum: string
{
    case ACTIVE = 'active';

    case DISABLED = 'disabled';
}
