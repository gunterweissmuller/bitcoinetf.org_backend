<?php

declare(strict_types=1);

namespace App\Enums\Billing\Withdrawal;

use App\Enums\InteractWithEnum;

enum StatusEnum: string
{
    use InteractWithEnum;

    case INIT = 'init';

    case PENDING = 'pending';

    case SUCCESS = 'success';

    case FAILED = 'failed';

    case EXPIRED = 'expired';
}
