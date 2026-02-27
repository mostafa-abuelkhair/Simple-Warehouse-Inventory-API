<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'warehouse_id' => 'required|integer|exists:warehouses,id',
            'inventory_item_id' => 'required|integer|exists:inventory_items,id',
            'quantity' => 'required|integer|min:0',
        ];
    }
}
