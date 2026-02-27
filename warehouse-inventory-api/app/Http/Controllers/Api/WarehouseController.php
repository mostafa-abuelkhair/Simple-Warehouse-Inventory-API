<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;
use App\Http\Resources\StockResource;
use App\Http\Resources\WarehouseResource;
use App\Models\Warehouse;
use App\Services\WarehouseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;
use App\DTO\CreateWarehouseDto;
use App\DTO\UpdateWarehouseDto;

class WarehouseController extends Controller
{
    public function __construct(private WarehouseService $warehouseService)
    {}

    public function index(): AnonymousResourceCollection
    {
        $warehouses = $this->warehouseService->getAll();

        return WarehouseResource::collection($warehouses);
    }

    public function store(CreateWarehouseRequest $request): WarehouseResource
    {
        $warehouse = $this->warehouseService->create(
            CreateWarehouseDto::fromArray($request->validated())
        );

        return new WarehouseResource($warehouse);
    }

    public function show(Warehouse $warehouse): WarehouseResource
    {
        $warehouse = $this->warehouseService->show($warehouse);

        return new WarehouseResource($warehouse);
    }

    public function update(UpdateWarehouseRequest $request, Warehouse $warehouse): WarehouseResource
    {
        $warehouse = $this->warehouseService->update(
            $warehouse,
            UpdateWarehouseDto::fromArray($request->validated())
        );

        return new WarehouseResource($warehouse);
    }

    public function destroy(Warehouse $warehouse): JsonResponse
    {
        $this->warehouseService->delete($warehouse);

        return response()->json(['message' => 'Warehouse deleted successfully']);
    }


    public function inventory(Warehouse $warehouse): AnonymousResourceCollection
    {
        $stocks = Cache::remember(
            "warehouse_{$warehouse->id}_inventory",
            60,
            fn () => $warehouse->stocks()->with('inventoryItem')->get()
        );

        return StockResource::collection($stocks);
    }
}
