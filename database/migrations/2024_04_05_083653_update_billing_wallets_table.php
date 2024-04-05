<?php

declare(strict_types=1);

use App\Enums\Billing\Wallet\WithdrawalMethodEnum;
use App\Helpers\MigrationHelper;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        MigrationHelper::modifyEnumColumn(
            'billing.wallets',
            'withdrawal_method',
            WithdrawalMethodEnum::values(),
            'wallets_withdrawal_method_check'
        );
    }

    public function down(): void
    {
    }
};
