<?php

declare(strict_types=1);

namespace App\Enums\Storage\S3;

enum DirPathEnum: string
{
    case Public = 'public';

    case Private = 'private';
}
