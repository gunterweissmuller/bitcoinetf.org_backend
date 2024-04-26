<?php

use App\Enums\Auth\Code\TypeEnum;
use App\Helpers\MigrationHelper;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        MigrationHelper::modifyEnumColumn(
            'auth.codes',
            'type',
            TypeEnum::values(),
            'codes_type_check'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
