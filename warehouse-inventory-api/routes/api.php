<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\WarehouseController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\StockTransferController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);

    //Inventory
    Route::apiResource('inventory', InventoryController::class);

    // Warehouses
    Route::get('/warehouses/{warehouse}/inventory', [WarehouseController::class, 'inventory']);
    Route::apiResource('warehouses', WarehouseController::class);

    // Stocks
    Route::post('/stocks', [StockController::class, 'store']);

    // Stock Transfers
    Route::get('/stock-transfers', [StockTransferController::class, 'index']);
    Route::post('/stock-transfers', [StockTransferController::class, 'store']);
    Route::get('/stock-transfers/{stockTransfer}', [StockTransferController::class, 'show']);
});
