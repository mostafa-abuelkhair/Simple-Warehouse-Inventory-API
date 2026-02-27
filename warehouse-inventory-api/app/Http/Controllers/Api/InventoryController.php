<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInventoryItemRequest;
use App\Http\Requests\UpdateInventoryItemRequest;
use App\Http\Resources\InventoryItemResource;
use App\Models\InventoryItem;
use App\DTO\CreateInventoryItemDto;
use App\DTO\UpdateInventoryItemDto;
use App\Services\InventoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class InventoryController extends Controller
{
    public function __construct(private InventoryService $inventoryService)
    {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $items = $this->inventoryService->getAll($request);

        return InventoryItemResource::collection($items);
    }

    public function store(CreateInventoryItemRequest $request): InventoryItemResource
    {
        $item = $this->inventoryService->create(
            CreateInventoryItemDto::fromArray($request->validated())
        );

        return new InventoryItemResource($item);
    }

    public function show(InventoryItem $inventory): InventoryItemResource
    {
        $item = $this->inventoryService->show($inventory);

        return new InventoryItemResource($item);
    }

    public function update(UpdateInventoryItemRequest $request, InventoryItem $inventory): InventoryItemResource
    {
        $item = $this->inventoryService->update(
            $inventory,
            UpdateInventoryItemDto::fromArray($request->validated())
        );

        return new InventoryItemResource($item);
    }

    public function destroy(InventoryItem $inventory): JsonResponse
    {
        $this->inventoryService->delete($inventory);

        return response()->json(['message' => 'Inventory item deleted successfully']);
    }
}
