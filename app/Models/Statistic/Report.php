<?php

declare(strict_types=1);

namespace App\Models\Statistic;

use App\Models\Storage\File;
use App\Models\Users\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Report extends Model
{
    use HasUuids;

    public $timestamps = false;

    protected $table = 'statistics.reports';

    protected $primaryKey = 'uuid';

    protected $dates = [
        'created_at',
    ];

    protected $fillable = [
        'account_uuid',
        'file_uuid',
        'type',
        'created_at'
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }
}
