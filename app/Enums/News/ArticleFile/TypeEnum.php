<?php

declare(strict_types=1);

namespace App\Enums\News\ArticleFile;

use App\Enums\InteractWithEnum;

enum TypeEnum: string
{
    use InteractWithEnum;

    case MAIN = 'main';

    case PREVIEW = 'preview';
}
