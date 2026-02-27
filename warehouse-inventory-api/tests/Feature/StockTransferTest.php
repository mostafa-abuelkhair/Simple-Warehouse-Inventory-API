<?php

use App\Models\InventoryItem;
use App\Models\Stock;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can transfer stock between warehouses successfully', function () {
    $user = User::factory()->create();
    $fromWarehouse = Warehouse::factory()->create();
    $toWarehouse = Warehouse::factory()->create();
    $item = InventoryItem::factory()->create();

    Stock::factory()->create([
        'warehouse_id' => $fromWarehouse->id,
        'inventory_item_id' => $item->id,
        'quantity' => 100,
    ]);

    $response = $this->actingAs($user)->postJson('/api/stock-transfers', [
        'from_warehouse_id' => $fromWarehouse->id,
        'to_warehouse_id' => $toWarehouse->id,
        'inventory_item_id' => $item->id,
        'quantity' => 30,
    ]);

    $response->assertStatus(201)
        ->assertJsonPath('data.quantity', 30)
        ->assertJsonPath('data.status', 'completed');

    $this->assertDatabaseHas('stocks', [
        'warehouse_id' => $fromWarehouse->id,
        'inventory_item_id' => $item->id,
        'quantity' => 70,
    ]);

    $this->assertDatabaseHas('stocks', [
        'warehouse_id' => $toWarehouse->id,
        'inventory_item_id' => $item->id,
        'quantity' => 30,
    ]);

    $this->assertDatabaseHas('stock_transfers', [
        'from_warehouse_id' => $fromWarehouse->id,
        'to_warehouse_id' => $toWarehouse->id,
        'inventory_item_id' => $item->id,
        'quantity' => 30,
        'status' => 'completed',
        'transferred_by' => $user->id,
    ]);
});

it('rejects transfer with insufficient stock via API', function () {
    $user = User::factory()->create();
    $fromWarehouse = Warehouse::factory()->create();
    $toWarehouse = Warehouse::factory()->create();
    $item = InventoryItem::factory()->create();

    Stock::factory()->create([
        'warehouse_id' => $fromWarehouse->id,
        'inventory_item_id' => $item->id,
        'quantity' => 5,
    ]);

    $response = $this->actingAs($user)->postJson('/api/stock-transfers', [
        'from_warehouse_id' => $fromWarehouse->id,
        'to_warehouse_id' => $toWarehouse->id,
        'inventory_item_id' => $item->id,
        'quantity' => 50,
    ]);

    $response->assertStatus(422);
});

it('requires authentication for stock transfer', function () {
    $response = $this->postJson('/api/stock-transfers', [
        'from_warehouse_id' => 1,
        'to_warehouse_id' => 2,
        'inventory_item_id' => 1,
        'quantity' => 10,
    ]);

    $response->assertStatus(401);
});
