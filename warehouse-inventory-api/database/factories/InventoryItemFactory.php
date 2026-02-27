<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\InventoryItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryItemFactory extends Factory
{
    protected $model = InventoryItem::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'sku' => strtoupper(fake()->unique()->bothify('???-#####')),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 1, 1000),
        ];
    }
}
