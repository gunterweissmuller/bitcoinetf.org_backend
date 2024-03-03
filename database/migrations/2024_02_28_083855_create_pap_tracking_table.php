<?php

declare(strict_types=1);

use App\Enums\Pap\Asset\AssetEnum;
use App\Enums\Pap\Event\EventEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pap.tracking', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->uuid('account_uuid')->unsigned();
            $table->enum('event_type', EventEnum::values())->nullable();
            $table->string('pap_id')->nullable();
            $table->string('utm_label')->nullable();
            $table->float('real_amount')->nullable();
            $table->enum('amount_type', AssetEnum::values())->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pap.tracking');
    }
};