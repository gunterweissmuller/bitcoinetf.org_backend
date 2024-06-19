<?php

declare(strict_types=1);

namespace App\Models\Newsletter;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class Subscription extends Model
{
    use HasUuids;

    protected $table = 'newsletter.subscriptions';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'email',
        'sent',
    ];
}
