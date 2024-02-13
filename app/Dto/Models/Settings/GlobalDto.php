<?php

declare(strict_types=1);

namespace App\Dto\Models\Settings;

use App\Dto\DtoInterface;
use App\Enums\Settings\Global\TypeEnum;

final class GlobalDto implements DtoInterface
{
    public function __construct(
        private ?string $name,
        private ?string $symbol,
        private ?string $type,
        private bool|string|float|int|null $value,
        private ?string $createdAt,
        private ?string $updatedAt,
    ) {}

    public static function fromArray(array $arguments): self
    {
        $type = $arguments['type'] ?? null;
        $value = $arguments['value'] ?? null;

        $value = match ($type) {
            TypeEnum::STRING->value => (string) $value,
            TypeEnum::BOOLEAN->value => (bool) $value,
            TypeEnum::FLOAT->value => (float) $value,
            TypeEnum::INTEGER->value => (int) $value,
        };

        return new self(
            $arguments['name'] ?? null,
            $arguments['symbol'] ?? null,
            $arguments['type'] ?? null,
            $value,
            $arguments['created_at'] ?? null,
            $arguments['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'symbol' => $this->symbol,
            'type' => $this->type,
            'value' => $this->value,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setKey(?string $key): void
    {
        $this->key = $key;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getValue(): bool|string|float|int|null
    {
        return $this->value;
    }

    public function setValue(bool|string|float|int|null $value): void
    {
        $this->value = $value;
    }

    public function getCreatedAt(): bool|string|null
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
