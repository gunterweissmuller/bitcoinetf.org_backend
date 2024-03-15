<?php

declare(strict_types=1);

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Code
 * @property string $uuid
 * @property string $account_uuid
 * @property string $status
 * @property string $type
 * @property string $code
 * @property string $revoked_at
 * @property string $expired_at
 * @property string $created_at
 * @property string $updated_at
 *
 * @package App\Models\Users
 */
final class Code extends Model
{
    use HasUuids;

    protected $table = 'auth.codes';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'account_uuid',
        'status',
        'type',
        'code',
        'revoked_at',
        'expired_at',
    ];

    protected $casts = [
        'code' => 'string',
    ];
}
