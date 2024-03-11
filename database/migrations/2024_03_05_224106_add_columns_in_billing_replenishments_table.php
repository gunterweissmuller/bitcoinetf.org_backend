<?php

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
        Schema::table('billing.replenishments', function (Blueprint $table) {
            $table->float('dividend_btc_amount')->nullable();
            $table->float('dividend_usdt_amount')->nullable();
            $table->float('dividend_resp_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('billing.replenishments', function (Blueprint $table) {
            $table->dropColumn('dividends_btc_amount');
            $table->dropColumn('dividend_usdt_amount');
            $table->dropColumn('dividend_resp_amount');
        });
    }
};
