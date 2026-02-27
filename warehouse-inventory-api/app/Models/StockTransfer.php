<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TransferStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_warehouse_id',
        'to_warehouse_id',
        'inventory_item_id',
        'quantity',
        'status',
        'transferred_by',
    ];

    protected function casts(): array
    {
        return [
            'status' => TransferStatus::class,
            'quantity' => 'integer',
        ];
    }

    public function fromWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'from_warehouse_id');
    }

    public function toWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'to_warehouse_id');
    }

    public function inventoryItem(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class);
    }

    public function transferredByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'transferred_by');
    }
}
