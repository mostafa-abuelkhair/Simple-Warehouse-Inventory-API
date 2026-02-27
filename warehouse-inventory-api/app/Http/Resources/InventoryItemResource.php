<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'description' => $this->description,
            'price' => (float) $this->price,
            'stocks' => StockResource::collection($this->whenLoaded('stocks')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
