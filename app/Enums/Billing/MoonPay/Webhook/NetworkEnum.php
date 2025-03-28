<?php

declare(strict_types=1);

namespace App\Enums\Billing\MoonPay\Webhook;

use App\Enums\InteractWithEnum;

enum NetworkEnum: string
{
    use InteractWithEnum;

    case Tron = 'tron';

    case Polygon = 'polygon';

    case Ethereum = 'ethereum';
}
