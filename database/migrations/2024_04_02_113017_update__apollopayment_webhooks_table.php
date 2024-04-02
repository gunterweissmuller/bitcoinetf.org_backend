<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('apollopayment.webhooks', function (Blueprint $table) {
            $table->unique('webhook_id');
            $table->unique('tx');
            $table->json('payload')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apollopayment.webhooks', function (Blueprint $table) {
            $table->dropUnique('webhook_id');
            $table->dropUnique('tx');
            $table->dropColumn('payload');
        });
    }
};

