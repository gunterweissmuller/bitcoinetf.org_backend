<?php

declare(strict_types=1);

namespace App\Enums\Billing\Payment;

use App\Enums\InteractWithEnum;

enum DescTypeEnum: string
{
    use InteractWithEnum;

    case NONE = 'none';

    case WELCOME_BONUS = 'welcome_bonus';

    case WELCOME_BONUS_REF = 'welcome_bonus_ref';

    case KYC_BONUS = 'kyc_bonus';

    case RUSSIA_BONUS = 'russia_bonus';

}
