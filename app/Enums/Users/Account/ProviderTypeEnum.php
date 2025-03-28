<?php

declare(strict_types=1);

namespace App\Enums\Users\Account;

use App\Enums\InteractWithEnum;

enum ProviderTypeEnum: string
{
    use InteractWithEnum;

    case Email = 'email';

    case Google = 'google';

    case Metamask = 'metamask';

    case Apple = 'apple';

    case Telegram = 'telegram';

    case Facebook = 'facebook';

    case WalletConnect = 'wallet_connect';
}
