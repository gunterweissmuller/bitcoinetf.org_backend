<?php

declare(strict_types=1);

namespace App\Enums;

trait InteractWithEnum
{
    public static function find(mixed $needle): self|null
    {
        if (in_array($needle, self::names())) {
            return constant("self::$needle");
        }
        if (in_array($needle, self::values())) {
            return self::tryFrom($needle);
        }

        return null;
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }
}
