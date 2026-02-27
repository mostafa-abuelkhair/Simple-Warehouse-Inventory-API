<?php

declare(strict_types=1);

namespace App\DTO;

class UpdateInventoryItemDto
{
    public function __construct(
        public ?string $name = null,
        public ?string $sku = null,
        public ?string $description = null,
        public ?float $price = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            sku: $data['sku'] ?? null,
            description: $data['description'] ?? null,
            price: isset($data['price']) ? (float) $data['price'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'sku' => $this->sku,
            'description' => $this->description,
            'price' => $this->price,
        ], fn ($value) => $value !== null);
    }
}
