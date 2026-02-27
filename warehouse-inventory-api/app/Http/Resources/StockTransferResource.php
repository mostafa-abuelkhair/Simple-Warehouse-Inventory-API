<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StockTransferResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'from_warehouse' => new WarehouseResource($this->whenLoaded('fromWarehouse')),
            'to_warehouse' => new WarehouseResource($this->whenLoaded('toWarehouse')),
            'inventory_item' => new InventoryItemResource($this->whenLoaded('inventoryItem')),
            'quantity' => $this->quantity,
            'status' => $this->status,
            'transferred_by' => new UserResource($this->whenLoaded('transferredByUser')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
