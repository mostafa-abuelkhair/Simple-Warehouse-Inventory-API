<?php

declare(strict_types=1);

namespace App\Observers;

use App\Events\LowStockDetected;
use App\Models\Stock;

class StockObserver
{
    private const LOW_STOCK_THRESHOLD = 5;

    public function created(Stock $stock): void
    {
        $this->checkLowStock($stock);
    }

    public function updated(Stock $stock): void
    {
        $this->checkLowStock($stock);
    }

    private function checkLowStock(Stock $stock): void
    {
        if ($stock->quantity <= self::LOW_STOCK_THRESHOLD) {
            LowStockDetected::dispatch($stock);
        }
    }
}
