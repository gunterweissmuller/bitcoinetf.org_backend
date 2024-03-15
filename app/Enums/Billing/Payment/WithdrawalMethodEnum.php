<?php

declare(strict_types=1);

namespace App\Enums\Billing\Payment;

use App\Enums\InteractWithEnum;

enum WithdrawalMethodEnum: string
{
    use InteractWithEnum;

    case NONE = 'none';

    case BITCOIN_ON_CHAIN = 'bitcoin_on_chain';

    case BITCOIN_LIGHTNING = 'bitcoin_lightning';
}
