<?php

declare(strict_types=1);

namespace App\Enums\Billing\MoonPay\Webhook;

use App\Enums\InteractWithEnum;

enum TypeEnum: string
{
    use InteractWithEnum;

    case Pending = 'pending';

    case Completed = 'completed';

    case Failed = 'failed';
}
