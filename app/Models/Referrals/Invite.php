<?php

declare(strict_types=1);

namespace App\Models\Referrals;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class Invite extends Model
{
    use HasUuids;

    protected $table = 'referrals.invited';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'code_uuid',
        'account_uuid',
    ];
}
