<?php

declare(strict_types=1);

namespace App\Enums\Settings\Global;

use App\Enums\InteractWithEnum;

enum SymbolEnum: string
{
    use InteractWithEnum;

    case PROJECTED_APY = 'projected_apy';

    case MINIMUM_APY = 'minimum_apy';

    case WELCOME_BONUS = 'welcome_bonus';

    case WELCOME_REF_BONUS = 'welcome_ref_bonus';

    case DEFAULT_BONUS = 'default_bonus';

    case KYC_BONUS = 'kyc_bonus';

    case RUSSIA_BONUS = 'russia_bonus';

    case INCREASED_MINIMUM_APY = 'increased_minimum_apy';

    case MERCHANT001_STATUS = 'merchant001_status';

    case TRC_BONUS = 'trc_bonus';

    case TRC_BONUS_DECREASE = 'trc_bonus_decrease';

    case MIN_REPLENISHMENT_AMOUNT = 'min_replenishment_amount';
}
