<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\LowStockDetected;
use App\Mail\LowStockAlert;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendLowStockNotification implements ShouldQueue
{
    public function handle(LowStockDetected $event): void
    {
        $stock = $event->stock->load(['warehouse', 'inventoryItem']);

        Log::warning('Low stock detected', [
            'warehouse' => $stock->warehouse->name,
            'item' => $stock->inventoryItem->name,
            'sku' => $stock->inventoryItem->sku,
            'quantity' => $stock->quantity,
        ]);

        // simulate sending email to admin
        Mail::to('admin@warehouse.com')->send(new LowStockAlert($stock));
    }
}
