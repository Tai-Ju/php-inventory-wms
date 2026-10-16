<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product')?->id;

        return [
            'sku' => [
                'required',
                'string',
                'max:50',
                Rule::unique('products', 'sku')->ignore($productId),
            ],
            'name' => ['required', 'string', 'max:120'],
            'unit' => ['required', 'string', 'max:20'],
            'safety_stock' => ['required', 'integer', 'min:0'],
            'location' => ['nullable', 'string', 'max:80'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function attributes(): array
    {
        return [
            'sku' => '料號',
            'name' => '品名',
            'unit' => '單位',
            'safety_stock' => '安全庫存',
            'location' => '儲位',
            'notes' => '備註',
        ];
    }
}
