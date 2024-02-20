<?php

declare(strict_types=1);

use App\Enums\Users\Wallet\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
    */
    public function up(): void
    {
        Schema::create('users.wallets', function (Blueprint $table): void {
            $table->uuid()->unique()->primary();
            $table->uuid('account_uuid')->unsigned();
            $table->string('wallet')->nullable();
            $table->enum('status', StatusEnum::values())->default(StatusEnum::Notverified->value);
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
        Schema::dropIfExists('users.wallets');
    }
};
