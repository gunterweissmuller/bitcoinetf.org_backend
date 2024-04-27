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
        Schema::create('users.metadata', function (Blueprint $table) {
            $table->uuid()->unique()->primary();
            $table->uuid('account_uuid')->unsigned();
            $table->ipAddress('ipv4_address')->nullable();
            $table->longText('user_agent')->nullable();
            $table->longText('location')->nullable();

            $table->timestamps();

            $table
                ->foreign('account_uuid')
                ->references('uuid')
                ->on('users.accounts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users.metadata');
    }
};
