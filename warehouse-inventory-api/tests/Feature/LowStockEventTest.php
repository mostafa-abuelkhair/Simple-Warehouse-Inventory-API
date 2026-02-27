<?php

use App\Events\LowStockDetected;
use App\Models\InventoryItem;
use App\Models\Stock;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

uses(RefreshDatabase::class);

it('fires LowStockDetected event when stock drops to threshold', function () {
    Event::fake([LowStockDetected::class]);

    $user = User::factory()->create();
    $fromWarehouse = Warehouse::factory()->create();
    $toWarehouse = Warehouse::factory()->create();
    $item = InventoryItem::factory()->create();

    Stock::factory()->create([
        'warehouse_id' => $fromWarehouse->id,
        'inventory_item_id' => $item->id,
        'quantity' => 8,
    ]);

    // transfer 5 units
    $this->actingAs($user)->postJson('/api/stock-transfers', [
        'from_warehouse_id' => $fromWarehouse->id,
        'to_warehouse_id' => $toWarehouse->id,
        'inventory_item_id' => $item->id,
        'quantity' => 5,
    ])->assertStatus(201);

    Event::assertDispatched(LowStockDetected::class, function ($event) use ($fromWarehouse, $item) {
        return $event->stock->warehouse_id === $fromWarehouse->id
            && $event->stock->inventory_item_id === $item->id;
    });
});

it('does not fire LowStockDetected event when stock is above threshold', function () {
    Event::fake([LowStockDetected::class]);

    $user = User::factory()->create();
    $fromWarehouse = Warehouse::factory()->create();
    $toWarehouse = Warehouse::factory()->create();
    $item = InventoryItem::factory()->create();

    Stock::factory()->create([
        'warehouse_id' => $fromWarehouse->id,
        'inventory_item_id' => $item->id,
        'quantity' => 100,
    ]);

    // ensure destination stock exists
    Stock::factory()->create([
        'warehouse_id' => $toWarehouse->id,
        'inventory_item_id' => $item->id,
        'quantity' => 20,
    ]);

    // transfer 10 units
    $this->actingAs($user)->postJson('/api/stock-transfers', [
        'from_warehouse_id' => $fromWarehouse->id,
        'to_warehouse_id' => $toWarehouse->id,
        'inventory_item_id' => $item->id,
        'quantity' => 10,
    ])->assertStatus(201);

    Event::assertNotDispatched(LowStockDetected::class);
});

it('fires LowStockDetected when stock is updated to low quantity', function () {
    Event::fake([LowStockDetected::class]);

    $user = User::factory()->create();
    $warehouse = Warehouse::factory()->create();
    $item = InventoryItem::factory()->create();

    $this->actingAs($user)->postJson('/api/stocks', [
        'warehouse_id' => $warehouse->id,
        'inventory_item_id' => $item->id,
        'quantity' => 3,
    ])->assertStatus(201);

    Event::assertDispatched(LowStockDetected::class);
});
