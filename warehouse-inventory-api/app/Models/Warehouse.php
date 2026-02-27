<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
    ];

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function stockTransfersFrom(): HasMany
    {
        return $this->hasMany(StockTransfer::class, 'from_warehouse_id');
    }

    public function stockTransfersTo(): HasMany
    {
        return $this->hasMany(StockTransfer::class, 'to_warehouse_id');
    }
}
