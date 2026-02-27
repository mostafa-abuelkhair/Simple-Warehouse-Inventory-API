<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\InventoryItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    protected $model = Stock::class;

    public function definition(): array
    {
        return [
            'warehouse_id' => Warehouse::factory(),
            'inventory_item_id' => InventoryItem::factory(),
            'quantity' => fake()->numberBetween(0, 500),
        ];
    }
}
