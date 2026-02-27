<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInventoryItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'sku' => 'sometimes|string|max:100|unique:inventory_items,sku,' . $this->route('inventory_item')?->id,
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
        ];
    }
}
