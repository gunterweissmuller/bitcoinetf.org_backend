<?php

declare(strict_types=1);

namespace App\Enums\Pap\Asset;

use App\Enums\InteractWithEnum;

enum AssetEnum: string
{
    use InteractWithEnum;

    case Tron = 'usdt_tron';

    case FiatMerchant001 = 'usd_fiat_merchant001';
}
