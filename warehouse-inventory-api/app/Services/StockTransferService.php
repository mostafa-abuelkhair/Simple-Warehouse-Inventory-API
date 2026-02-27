<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\CreateStockTransferDto;
use App\Enums\TransferStatus;
use App\Models\Stock;
use App\Models\StockTransfer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockTransferService
{
    public function getAll(): LengthAwarePaginator
    {
        return StockTransfer::with(['fromWarehouse', 'toWarehouse', 'inventoryItem', 'transferredByUser'])
            ->latest()
            ->paginate(15);
    }

    public function show(StockTransfer $transfer): StockTransfer
    {
        return $transfer->load(['fromWarehouse', 'toWarehouse', 'inventoryItem', 'transferredByUser']);
    }

    public function transfer(CreateStockTransferDto $dto): StockTransfer
    {
        return DB::transaction(function () use ($dto) {

            // lock the source stock row to prevent race conditions
            $sourceStock = Stock::where('warehouse_id', $dto->from_warehouse_id)
                ->where('inventory_item_id', $dto->inventory_item_id)
                ->lockForUpdate()
                ->first();

            if (! $sourceStock || $sourceStock->quantity < $dto->quantity) {
                throw ValidationException::withMessages([
                    'quantity' => ['Insufficient stock. Available: ' . ($sourceStock?->quantity ?? 0)],
                ]);
            }

            $sourceStock->decrement('quantity', $dto->quantity);

            $destinationStock = Stock::updateOrCreate(
                [
                    'warehouse_id' => $dto->to_warehouse_id,
                    'inventory_item_id' => $dto->inventory_item_id,
                ],
                []
            );
            $destinationStock->increment('quantity', $dto->quantity);

            $transfer = StockTransfer::create([
                'from_warehouse_id' => $dto->from_warehouse_id,
                'to_warehouse_id' => $dto->to_warehouse_id,
                'inventory_item_id' => $dto->inventory_item_id,
                'quantity' => $dto->quantity,
                'status' => TransferStatus::COMPLETED->value,
                'transferred_by' => Auth::id(),
            ]);

            Cache::forget("warehouse_{$dto->from_warehouse_id}_inventory");
            Cache::forget("warehouse_{$dto->to_warehouse_id}_inventory");

            return $transfer->load(['fromWarehouse', 'toWarehouse', 'inventoryItem', 'transferredByUser']);
        });
    }
}

