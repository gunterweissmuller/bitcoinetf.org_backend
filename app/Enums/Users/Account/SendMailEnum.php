<?php

declare(strict_types=1);

namespace App\Enums\Users\Account;

use App\Enums\InteractWithEnum;

enum SendMailEnum: string
{
    use InteractWithEnum;

    case Yes = 'Y';

    case No = 'N';
}
