<?php

declare(strict_types=1);

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WalletConnect
 * @property string $uuid
 * @property string $account_uuid
 * @property string $address
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @package App\Models\Users
 */
final class WalletConnect extends Model
{
    use HasUuids;

    protected $table = 'users.wallet_connects';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'account_uuid',
        'address',
        'status',
    ];
}
