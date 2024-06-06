<?php

declare(strict_types=1);

namespace App\Enums\Billing\Payment;

use App\Enums\InteractWithEnum;

enum ApolloPaymentWebhookTypeEnum: string
{
    use InteractWithEnum;

    case DEPOSIT = 'deposit';

    case WITHDRAW = 'withdraw';

    case PAYOUT = 'payout';
}
