<?php

declare(strict_types=1);

namespace App\DTO;

class UpdateWarehouseDto
{
    public function __construct(
        public ?string $name = null,
        public ?string $location = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            location: $data['location'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'location' => $this->location,
        ], fn ($value) => $value !== null);
    }
}
