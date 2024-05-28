<?php

declare(strict_types=1);

use App\Enums\Billing\Payment\TypeEnum;
use App\Helpers\MigrationHelper;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        MigrationHelper::modifyEnumColumn(
            'billing.payments',
            'type',
            TypeEnum::values(),
            'payments_type_check'
        );
    }

    public function down(): void
    {
    }
};
