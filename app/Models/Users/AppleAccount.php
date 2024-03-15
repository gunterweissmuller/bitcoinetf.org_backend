<?php

declare(strict_types=1);

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AppleAccount
 * @property string $uuid
 * @property string $account_uuid
 * @property string $apple_id
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @package App\Models\Users
 */
final class AppleAccount extends Model
{
    use HasUuids;

    protected $table = 'users.apple_accounts';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'account_uuid',
        'apple_id',
        'status',
    ];
}
