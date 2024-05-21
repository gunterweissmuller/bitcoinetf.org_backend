<?php

declare(strict_types=1);

namespace app\Enums\Billing\Sell;

use App\Enums\InteractWithEnum;

enum SellPeriodEnum: string
{
    use InteractWithEnum;

    case UP_TO_1_DAY = 'up_to_1_day';

    case FROM_1_DAY_TO_32_DAYS = 'from_1_day_to_32_days';

    case FROM_32_DAY_TO_1095_DAYS = 'from_32_day_to_1095_days';

    case MORE_THAN_1095_DAYS = 'more_than_1095_days';

}
