<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('apollopayment.webhooks', function (Blueprint $table) {
            $table->dropUnique('apollopayment_webhooks_tx_unique');
            $table->string('tx')->nullable()->change();
        });
    }

    public function down(): void
    {
    }
};
