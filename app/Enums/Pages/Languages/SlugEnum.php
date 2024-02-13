<?php

declare(strict_types=1);

namespace App\Enums\Pages\Languages;

enum SlugEnum: string
{
    case ENG = 'eng';

    public static function default(): string
    {
        return self::ENG->value;
    }

    public static function defaultId(): int
    {
        return 1;
    }
}
