<?php

declare(strict_types=1);

namespace App\Models\Kyc;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class Form extends Model
{
    use HasUuids;

    protected $table = 'kyc.forms';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'title',
        'status',
    ];
}
