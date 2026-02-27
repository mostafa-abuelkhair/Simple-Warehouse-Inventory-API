<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'description',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function stockTransfers(): HasMany
    {
        return $this->hasMany(StockTransfer::class);
    }


    public function scopeSearch(Builder $query, ?string $name = null, ?float $minPrice = null, ?float $maxPrice = null): Builder
    {
        return $query
            ->when($name, fn (Builder $q, string $name) => $q->where('name', 'LIKE', "%{$name}%"))
            ->when($minPrice !== null, fn (Builder $q) => $q->where('price', '>=', $minPrice))
            ->when($maxPrice !== null, fn (Builder $q) => $q->where('price', '<=', $maxPrice));
    }
}
