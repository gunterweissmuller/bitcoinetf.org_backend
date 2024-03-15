<?php

namespace Database\Seeders;

use App\Enums\Users\Account\ProviderTypeEnum;
use App\Models\Users\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateUsersTableProviderTypeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Account::where('provider_type', null)->update(['provider_type' => ProviderTypeEnum::Email->value]);
    }
}
