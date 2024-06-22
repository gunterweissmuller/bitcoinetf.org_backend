<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

final class TestGenerateTemplates extends Command
{
    protected $signature = 'test:generate-template';

    protected $description = '';

    public function handle(): void
    {
        $this->info('START');

        $data = [
            'accountUuid' => '456465',
            'username' => 'username',
            'firstName' => 'first name',
            'email' => 'email.com',
            'password' => 'password',
        ];

        $html = View::make('emails.v1.auth.your-password-v2', $data)->render();
        $directory = public_path('generated-html');
        $filePath = $directory . '/example.html';

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
        File::put($filePath, $html);

        $this->info('END');
    }
}
