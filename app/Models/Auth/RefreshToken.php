<?php

declare(strict_types=1);

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RefreshToken
 * @property string $uuid
 * @property string $account_uuid
 * @property string $token
 * @property string $status
 * @property string $revoked_at
 * @property string $expired_at
 * @property string $created_at
 * @property string $updated_at
 *
 * @package App\Models\Users
 */
final class RefreshToken extends Model
{
    use HasUuids;

    protected $table = 'auth.refresh_tokens';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'account_uuid',
        'token',
        'status',
        'revoked_at',
        'expired_at',
    ];
}
