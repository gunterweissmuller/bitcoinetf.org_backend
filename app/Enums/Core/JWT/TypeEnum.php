<?php

declare(strict_types=1);

namespace App\Enums\Core\JWT;

enum TypeEnum: string
{
    case Access = 'access';

    case Refresh = 'refresh';
}
