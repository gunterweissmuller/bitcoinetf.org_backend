<?php

declare(strict_types=1);

namespace App\Enums\Settings\Global;

use App\Enums\InteractWithEnum;

enum DividendReportLifeTimeEnum: string
{
    use InteractWithEnum;

    case EVERY_TIME = '120'; // 1 day -> 86400, 6 day -> 518400
}
