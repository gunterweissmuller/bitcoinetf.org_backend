<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Users\AppleAccount\StatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users.apple_accounts', function (Blueprint $table) {
            $table->uuid()->unique()->primary();
            $table->uuid('account_uuid')->unsigned();
            $table->string('apple_id')->nullable();
            $table->enum('status', StatusEnum::values())->default(StatusEnum::AwaitConfirm->value);
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
        Schema::dropIfExists('users.apple_accounts');
    }
};
