<?php

declare(strict_types=1);

namespace App\Enums\Storage\File;

use App\Enums\InteractWithEnum;

enum ExtensionEnum: string
{
    use InteractWithEnum;

    case JPG = 'jpg';

    case JPEG = 'jpeg';

    case PNG = 'png';

    case BMP = 'bmp';

    case WEBP = 'webp';

    case GIF = 'gif';

    case PDF = 'pdf';

    case DOC = 'doc';

    case DOCX = 'docx';

    case SVG = 'svg';
}
