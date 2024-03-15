<?php

declare(strict_types=1);

namespace App\Enums\Kyc\Session;

use App\Enums\InteractWithEnum;

enum StatusEnum: string
{
    use InteractWithEnum;

    case New = 'new';

    case InProcess = 'in-process';

    case Passed = 'passed';
}
