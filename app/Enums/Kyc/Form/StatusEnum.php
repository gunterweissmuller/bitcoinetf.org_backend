<?php

declare(strict_types=1);

namespace App\Enums\Kyc\Form;

use App\Enums\InteractWithEnum;

enum StatusEnum: string
{
    use InteractWithEnum;

    case Enabled = 'enabled';

    case Disabled = 'disabled';
}
