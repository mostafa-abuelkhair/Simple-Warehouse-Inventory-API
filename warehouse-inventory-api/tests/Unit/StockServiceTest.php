<?php

use App\Models\InventoryItem;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Services\StockTransferService;
use App\DTO\CreateStockTransferDto;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('throws exception when transferring more stock than available', function () {
    $warehouse = Warehouse::factory()->create();
    $item = InventoryItem::factory()->create();

    Stock::factory()->create([
        'warehouse_id' => $warehouse->id,
        'inventory_item_id' => $item->id,
        'quantity' => 10,
    ]);

    $toWarehouse = Warehouse::factory()->create();

    $service = app(StockTransferService::class);

    $dto = CreateStockTransferDto::fromArray([
        'from_warehouse_id' => $warehouse->id,
        'to_warehouse_id' => $toWarehouse->id,
        'inventory_item_id' => $item->id,
        'quantity' => 20, // more than available
    ]);

    $this->actingAs(\App\Models\User::factory()->create());

    expect(fn () => $service->transfer($dto))
        ->toThrow(ValidationException::class);
});

it('throws exception when source stock does not exist', function () {
    $fromWarehouse = Warehouse::factory()->create();
    $toWarehouse = Warehouse::factory()->create();
    $item = InventoryItem::factory()->create();

    $service = app(StockTransferService::class);

    $dto = CreateStockTransferDto::fromArray([
        'from_warehouse_id' => $fromWarehouse->id,
        'to_warehouse_id' => $toWarehouse->id,
        'inventory_item_id' => $item->id,
        'quantity' => 5,
    ]);

    $this->actingAs(\App\Models\User::factory()->create());

    expect(fn () => $service->transfer($dto))
        ->toThrow(ValidationException::class);
});
