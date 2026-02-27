<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\TransferStatus;
use App\Models\InventoryItem;
use App\Models\StockTransfer;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockTransferFactory extends Factory
{
    protected $model = StockTransfer::class;

    public function definition(): array
    {
        return [
            'from_warehouse_id' => Warehouse::factory(),
            'to_warehouse_id' => Warehouse::factory(),
            'inventory_item_id' => InventoryItem::factory(),
            'quantity' => fake()->numberBetween(1, 50),
            'status' => TransferStatus::COMPLETED->value,
            'transferred_by' => User::factory(),
        ];
    }
}
