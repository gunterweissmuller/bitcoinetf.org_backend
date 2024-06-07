<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('billing.btc_purchases', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->float('rate');
            $table->integer('payments_updated')->default(0)->nullable();
            $table->float('amount')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('billing.btc_purchases');
    }
};
