<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\UpdateStockDto;
use App\Models\Stock;
use Illuminate\Support\Facades\Cache;

class StockService
{
    public function updateStock(UpdateStockDto $dto): Stock
    {
        $stock = Stock::updateOrCreate(
            [
                'warehouse_id' => $dto->warehouse_id,
                'inventory_item_id' => $dto->inventory_item_id,
            ],
            [
                'quantity' => $dto->quantity,
            ]
        );

        $this->invalidateWarehouseCache($dto->warehouse_id);

        return $stock->load(['warehouse', 'inventoryItem']);
    }

    public function invalidateWarehouseCache(int $warehouseId): void
    {
        Cache::forget("warehouse_{$warehouseId}_inventory");
    }
}

