<?php

declare(strict_types=1);

namespace App\Enums\Storage\File;

use App\Enums\InteractWithEnum;

enum TypeEnum: string
{
    use InteractWithEnum;

    case Avatar = 'avatar';

    case DriversLicense = 'drivers-license';

    case Passport = 'passport';

    case Selfie = 'selfie';

    case DividendsReport = 'dividends-report';

    case Receipt = 'receipt';

    case IMAGE = 'image';

    case DOCUMENT = 'document';

    public static function getExtensions(string $type): array
    {
        return match ($type) {
            self::Avatar->value,
            self::DriversLicense->value,
            self::Passport->value,
            self::Selfie->value => [
                ExtensionEnum::JPG->value,
                ExtensionEnum::JPEG->value,
                ExtensionEnum::PNG->value,
            ],
            self::DividendsReport->value,
            self::Receipt->value => [
                ExtensionEnum::PDF->value,
            ],
            default => [],
        };
    }
}
