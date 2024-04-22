<?php

declare(strict_types=1);

use App\Enums\Billing\Wallet\WithdrawalMethodEnum;
use App\Helpers\MigrationHelper;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        MigrationHelper::modifyEnumColumn(
            'billing.payments',
            'withdrawal_method',
            WithdrawalMethodEnum::values(),
            'payments_withdrawal_method_check'
        );
    }

    public function down(): void
    {
    }
};
