<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\CreateInventoryItemDto;
use App\DTO\UpdateInventoryItemDto;
use App\Models\InventoryItem;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class InventoryService
{
    public function getAll(Request $request): LengthAwarePaginator
    {
        $name = $request->query('name');
        $minPrice = $request->query('min_price') !== null ? (float) $request->query('min_price') : null;
        $maxPrice = $request->query('max_price') !== null ? (float) $request->query('max_price') : null;
        $warehouseId = $request->query('warehouse_id') !== null ? (int) $request->query('warehouse_id') : null;
        $perPage = (int) $request->query('per_page', 15);

        $query = InventoryItem::with('stocks.warehouse')
            ->search($name, $minPrice, $maxPrice);

        if ($warehouseId) {
            $query->whereHas('stocks', fn ($q) => $q->where('warehouse_id', $warehouseId));
        }

        return $query->paginate($perPage);
    }

    public function show(InventoryItem $item): InventoryItem
    {
        return $item->load('stocks.warehouse');
    }

    public function create(CreateInventoryItemDto $dto): InventoryItem
    {
        return InventoryItem::create($dto->toArray());
    }

    public function update(InventoryItem $item, UpdateInventoryItemDto $dto): InventoryItem
    {
        $item->update($dto->toArray());

        return $item->fresh();
    }

    public function delete(InventoryItem $item): bool
    {
        return $item->delete();
    }
}
