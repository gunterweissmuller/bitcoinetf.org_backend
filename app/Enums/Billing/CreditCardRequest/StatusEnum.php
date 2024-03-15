<?php

declare(strict_types=1);

namespace App\Enums\Billing\CreditCardRequest;

use App\Enums\InteractWithEnum;

enum StatusEnum: string
{
    use InteractWithEnum;

    case PENDING = 'pending';

    case PROCESSING = 'processing';

    case SUCCESS = 'success';
}
