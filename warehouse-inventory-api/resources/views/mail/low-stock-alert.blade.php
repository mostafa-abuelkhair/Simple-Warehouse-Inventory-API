<x-mail::message>
# Low Stock Alert

The following item has low stock and requires attention:

- **Item:** {{ $stock->inventoryItem->name }}
- **SKU:** {{ $stock->inventoryItem->sku }}
- **Warehouse:** {{ $stock->warehouse->name }}
- **Current Quantity:** {{ $stock->quantity }}

Please restock this item as soon as possible.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
