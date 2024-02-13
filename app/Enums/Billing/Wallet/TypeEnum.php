<?php

declare(strict_types=1);

namespace App\Enums\Billing\Wallet;

use App\Enums\InteractWithEnum;

enum TypeEnum: string
{
    use InteractWithEnum;

    case REFERRAL = 'referral';

    case BONUS = 'bonus';

    case DIVIDENDS = 'dividends';

    case VAULT = 'vault';
}
