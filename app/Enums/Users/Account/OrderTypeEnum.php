<?php

declare(strict_types=1);

namespace App\Enums\Users\Account;

use App\Enums\InteractWithEnum;

enum OrderTypeEnum: string
{
    use InteractWithEnum;

    case BTC = 'btc';

    case USDT = 'usdt';

    case InitBTC = 'init_btc';

    case InitUSDT = 'init_usdt';

}
