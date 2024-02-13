<?php

declare(strict_types=1);

namespace App\Http\Controllers\Docs;

use App\Exceptions\Core\NotFoundException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;

final class SwaggerController extends Controller
{
    private const PUBLIC_PATH = 'docs/swagger/v1/public/openapi-public.yaml';

    private const PRIVATE_PATH = 'docs/swagger/v1/private/openapi-private.yaml';

    public function public(): string
    {
        return File::get(base_path(self::PUBLIC_PATH));
    }

    public function private(): string
    {
        return File::get(base_path(self::PRIVATE_PATH));
    }

    public function swagger(string $type): View|Application|Factory
    {
        return match ($type) {
            'public' => view('docs.swagger', [
                'title' => 'ETF Public API Service',
                'url' => '/docs/swagger/openapi-public.yaml',
            ]),
            'private' => view('docs.swagger', [
                'title' => 'ETF Private API Service',
                'url' => '/docs/swagger/openapi-private.yaml',
            ]),
            default => throw new NotFoundException(),
        };
    }
}
