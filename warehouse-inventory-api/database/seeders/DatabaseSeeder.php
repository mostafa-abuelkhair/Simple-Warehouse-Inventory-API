<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\InventoryItem;
use App\Models\Stock;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@warehouse.com',
            'password' => Hash::make('password'),
        ]);

        // Create warehouses
        $warehouses = Warehouse::factory()->count(3)->create();

        // Create inventory items
        $items = InventoryItem::factory()->count(20)->create();

        // Create stock entries linking items to warehouses
        foreach ($warehouses as $warehouse) {
            foreach ($items->random(10) as $item) {
                Stock::factory()->create([
                    'warehouse_id' => $warehouse->id,
                    'inventory_item_id' => $item->id,
                    'quantity' => fake()->numberBetween(1, 200),
                ]);
            }
        }
    }
}
