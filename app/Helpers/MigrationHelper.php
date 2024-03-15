<?php

declare(strict_types=1);

namespace App\Helpers;

use Closure;
use Illuminate\Support\Facades\DB;

final class MigrationHelper
{
    public static function modifyEnumColumn(
        string   $table,
        string   $column,
        array    $values,
        ?string  $constraint = null,
        ?Closure $method = null
    ): void
    {
        $constraint = $constraint ?? "{$table}_{$column}_check";

        DB::statement("ALTER TABLE $table DROP CONSTRAINT $constraint");

        if ($method) {
            $method();
        }

        $result = join(', ', array_map(function ($value) {
            return sprintf("'%s'::character varying", $value);
        }, $values));

        DB::statement("ALTER TABLE $table ADD CONSTRAINT $constraint CHECK ($column::text = ANY (ARRAY[$result]::text[]))");
    }
}
