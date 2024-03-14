<?php

declare(strict_types=1);

namespace App\Enums\Users\Account;

use App\Enums\InteractWithEnum;

enum TypeEnum: string
{
    use InteractWithEnum;

    case Client = 'client';

    case Editor = 'editor';

    case Moderator = 'moderator';

    case Admin = 'admin';
}
