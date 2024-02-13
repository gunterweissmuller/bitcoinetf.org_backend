<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Str;
use StephenHill\Base58;
use StephenHill\GMPService;

trait HasUid
{
    public function initializeHasUid(): void
    {
        $this->usesUniqueIds = true;
    }

    public function uniqueIds(): array
    {
        return [$this->getKeyName()];
    }

    public function newUniqueId(): string
    {
        $gmp = new GMPService();
        $base58 = new Base58(null, $gmp);

        $lim = match ($this->sizeUid) {
            25 => 34,
            47 => 64,
        };

        return substr($base58->encode(Str::random($this->sizeUid)), 0, $lim);
    }

    public function resolveRouteBindingQuery($query, $value, $field = null): Relation
    {
        if ($field && in_array($field, $this->uniqueIds()) && ! Str::isUuid($value)) {
            throw (new ModelNotFoundException)->setModel(get_class($this), $value);
        }

        if (! $field && in_array($this->getRouteKeyName(), $this->uniqueIds()) && ! Str::isUuid($value)) {
            throw (new ModelNotFoundException)->setModel(get_class($this), $value);
        }

        return parent::resolveRouteBindingQuery($query, $value, $field);
    }

    public function getKeyType(): string
    {
        if (in_array($this->getKeyName(), $this->uniqueIds())) {
            return 'string';
        }

        return $this->keyType;
    }

    public function getIncrementing(): bool
    {
        if (in_array($this->getKeyName(), $this->uniqueIds())) {
            return false;
        }

        return $this->incrementing;
    }
}
