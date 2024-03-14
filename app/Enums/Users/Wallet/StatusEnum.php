<?php

declare(strict_types=1);

namespace App\Enums\Users\Wallet;

use App\Enums\InteractWithEnum;

enum StatusEnum: string
{
    use InteractWithEnum;

    case Verified = 'verified';

    case Notverified = 'not_verified';
}
