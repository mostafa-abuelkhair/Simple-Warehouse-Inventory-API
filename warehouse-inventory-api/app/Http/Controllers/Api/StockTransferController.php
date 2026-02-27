<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStockTransferRequest;
use App\Http\Resources\StockTransferResource;
use App\DTO\CreateStockTransferDto;
use App\Models\StockTransfer;
use App\Services\StockTransferService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StockTransferController extends Controller
{
    public function __construct(private StockTransferService $stockTransferService)
    {}

    public function index(): AnonymousResourceCollection
    {
        $transfers = $this->stockTransferService->getAll();

        return StockTransferResource::collection($transfers);
    }

    public function store(StoreStockTransferRequest $request): StockTransferResource
    {
        $transfer = $this->stockTransferService->transfer(
            CreateStockTransferDto::fromArray($request->validated())
        );

        return new StockTransferResource($transfer);
    }

    public function show(StockTransfer $stockTransfer): StockTransferResource
    {
        $transfer = $this->stockTransferService->show($stockTransfer);

        return new StockTransferResource($transfer);
    }
}
