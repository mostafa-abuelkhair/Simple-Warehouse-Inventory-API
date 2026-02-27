<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StockResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'warehouse_id' => $this->warehouse_id,
            'inventory_item_id' => $this->inventory_item_id,
            'quantity' => $this->quantity,
            'warehouse' => new WarehouseResource($this->whenLoaded('warehouse')),
            'inventory_item' => new InventoryItemResource($this->whenLoaded('inventoryItem')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
