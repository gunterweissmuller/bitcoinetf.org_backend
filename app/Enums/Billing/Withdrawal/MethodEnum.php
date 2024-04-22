<?php

declare(strict_types=1);

namespace App\Enums\Billing\Withdrawal;

enum MethodEnum: string
{
    case BITCOIN_ON_CHAIN = 'bitcoin_on_chain';

    case BITCOIN_LIGHTNING = 'bitcoin_lightning';

    case POLYGON_USDT = 'polygon_usdt';
}
