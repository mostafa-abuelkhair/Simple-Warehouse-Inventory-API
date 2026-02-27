<?php

declare(strict_types=1);

namespace App\DTO;

class CreateStockTransferDto
{
    public function __construct(
        public int $from_warehouse_id,
        public int $to_warehouse_id,
        public int $inventory_item_id,
        public int $quantity,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            from_warehouse_id: (int) $data['from_warehouse_id'],
            to_warehouse_id: (int) $data['to_warehouse_id'],
            inventory_item_id: (int) $data['inventory_item_id'],
            quantity: (int) $data['quantity'],
        );
    }

    public function toArray(): array
    {
        return [
            'from_warehouse_id' => $this->from_warehouse_id,
            'to_warehouse_id' => $this->to_warehouse_id,
            'inventory_item_id' => $this->inventory_item_id,
            'quantity' => $this->quantity,
        ];
    }
}
