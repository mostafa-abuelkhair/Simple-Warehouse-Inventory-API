<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from_warehouse_id' => 'required|integer|exists:warehouses,id',
            'to_warehouse_id' => 'required|integer|exists:warehouses,id|different:from_warehouse_id',
            'inventory_item_id' => 'required|integer|exists:inventory_items,id',
            'quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'to_warehouse_id.different' => 'The destination warehouse must be different from the source warehouse.',
        ];
    }
}
