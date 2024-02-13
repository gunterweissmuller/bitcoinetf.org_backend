<?php

declare(strict_types=1);

namespace App\Enums\Users\Account;

use App\Enums\InteractWithEnum;

enum StatusEnum: string
{
    use InteractWithEnum;

    case AwaitConfirm = 'await_confirm';

    case Enabled = 'enabled';

    case Disabled = 'disabled';
}
