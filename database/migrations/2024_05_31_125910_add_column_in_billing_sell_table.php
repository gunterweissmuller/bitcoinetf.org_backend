<?php

use App\Enums\Users\Account\OrderTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('billing.sell', function (Blueprint $table) {
            $table->float('exchange_rate_deduction')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('billing.sell', function (Blueprint $table) {
            $table->dropColumn('exchange_rate_deduction');
        });
    }
};

