<?php

declare(strict_types=1);

namespace App\Enums\Billing\Payment;

use App\Enums\InteractWithEnum;

enum ApolloPaymentWithdrawalStatusEnum: string
{
    use InteractWithEnum;

    case ERROR = 'error';

    case PROCESSED = 'processed';
}
