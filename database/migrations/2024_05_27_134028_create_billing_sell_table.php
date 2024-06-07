<?php

declare(strict_types=1);

use App\Enums\Billing\Withdrawal\StatusEnum;
use App\Enums\Billing\Withdrawal\MethodEnum;
use App\Enums\Billing\Sell\SellPeriodEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('billing.sell', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->uuid('account_uuid')->unsigned();
            $table->uuid('payment_uuid')->unsigned();
            $table->enum('status', StatusEnum::values())->nullable();
            $table->enum('period', SellPeriodEnum::values())->nullable();
            $table->enum('method', MethodEnum::values())->nullable();
            $table->string('destination')->nullable();
            $table->float('value')->nullable();
            $table->float('real_amount')->nullable();
            $table->float('termination_fee')->nullable();
            $table->float('transaction_fee')->nullable();
            $table->float('return_all_paid')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('billing.sell');
    }
};
