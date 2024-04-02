<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('apollopayment.webhooks', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->uuid('client_id')->unsigned();
            $table->uuid('webhook_id')->unique();
            $table->uuid('address_id')->nullable();
            $table->float('amount')->nullable();
            $table->string('currency')->nullable();
            $table->string('network')->nullable();
            $table->string('tx')->unique();
            $table->string('type')->nullable();
            $table->json('payload')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apollopayment.webhooks');
    }
};
