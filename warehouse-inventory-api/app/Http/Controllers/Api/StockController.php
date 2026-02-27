<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStockRequest;
use App\Http\Resources\StockResource;
use App\DTO\UpdateStockDto;
use App\Services\StockService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Models\Stock;

class StockController extends Controller
{
    public function __construct(private StockService $stockService)
    {}

    public function store(UpdateStockRequest $request): StockResource
    {
        $stock = $this->stockService->updateStock(
            UpdateStockDto::fromArray($request->validated())
        );

        return new StockResource($stock);
    }

}
