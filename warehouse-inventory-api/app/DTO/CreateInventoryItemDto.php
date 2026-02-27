<?php

declare(strict_types=1);

namespace App\DTO;

class CreateInventoryItemDto
{
    public function __construct(
        public string $name,
        public string $sku,
        public ?string $description,
        public float $price,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            sku: $data['sku'],
            description: $data['description'] ?? null,
            price: (float) $data['price'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'sku' => $this->sku,
            'description' => $this->description,
            'price' => $this->price,
        ];
    }
}
