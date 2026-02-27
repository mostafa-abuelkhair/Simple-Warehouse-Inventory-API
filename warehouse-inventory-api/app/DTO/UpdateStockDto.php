<?php

declare(strict_types=1);

namespace App\DTO;

class UpdateStockDto
{
    public function __construct(
        public int $warehouse_id,
        public int $inventory_item_id,
        public int $quantity,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            warehouse_id: (int) $data['warehouse_id'],
            inventory_item_id: (int) $data['inventory_item_id'],
            quantity: (int) $data['quantity'],
        );
    }

    public function toArray(): array
    {
        return [
            'warehouse_id' => $this->warehouse_id,
            'inventory_item_id' => $this->inventory_item_id,
            'quantity' => $this->quantity,
        ];
    }
}
