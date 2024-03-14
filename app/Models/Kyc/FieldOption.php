<?php

declare(strict_types=1);

namespace App\Models\Kyc;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class FieldOption extends Model
{
    use HasUuids;

    protected $table = 'kyc.field_options';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'field_uuid',
        'label',
        'value',
    ];
}
