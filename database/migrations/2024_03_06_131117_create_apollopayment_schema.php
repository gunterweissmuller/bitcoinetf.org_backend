<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::select('CREATE SCHEMA apollopayment');
    }

    public function down(): void
    {
        DB::select('DROP SCHEMA apollopayment CASCADE');
    }
};
