<?php

declare(strict_types=1);

namespace App\Enums\Kyc\Field;

use App\Enums\InteractWithEnum;

enum TypeEnum: string
{
    use InteractWithEnum;

    case Text = 'text';

    case Date = 'date';

    case Select = 'select';

    case File = 'file';

    case RadioGroup = 'radio-group';

    case Checkbox = 'checkbox';
}
