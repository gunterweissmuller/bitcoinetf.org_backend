<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('apollopayment.clients', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->uuid('account_uuid')->unsigned();
            $table->uuid('client_id')->unsigned();
            $table->string('webhook_url')->nullable();
            $table->string('ethereum_addr')->nullable();
            $table->string('tron_addr')->nullable();
            $table->string('polygon_addr')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apollopayment.clients');
    }
};
