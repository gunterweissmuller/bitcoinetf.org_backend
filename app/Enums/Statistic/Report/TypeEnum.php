<?php

declare(strict_types=1);

namespace App\Enums\Statistic\Report;

use App\Enums\InteractWithEnum;

enum TypeEnum: string
{
    use InteractWithEnum;

    case MONTHLY_PAYMENTS_REPORT = 'monthly_payments_report';
}
