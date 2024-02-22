<?php

declare(strict_types=1);

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Email
 * @property string $uuid
 * @property string $account_uuid
 * @property string $email
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @package App\Models\Users
 */
final class Email extends Model
{
    use HasUuids;

    protected $table = 'users.emails';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'account_uuid',
        'email',
        'status',
        'wallet',
    ];
}
