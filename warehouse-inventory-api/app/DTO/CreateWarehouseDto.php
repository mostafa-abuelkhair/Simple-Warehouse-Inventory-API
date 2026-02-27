<?php

declare(strict_types=1);

namespace App\DTO;

class CreateWarehouseDto
{
    public function __construct(
        public string $name,
        public string $location,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            location: $data['location'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'location' => $this->location,
        ];
    }
}
