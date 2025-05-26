<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class StoreOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'delivery_address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',

            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.price' => 'required|numeric|min:0',

            // Sizes validation
            'items.*.sizes' => 'required|array|min:1',
            'items.*.sizes.*.size_id' => [
                'required',
                'exists:sizes,id',
                function ($attribute, $value, $fail) {
                    preg_match('/items\.(\d+)\.sizes\.(\d+)\.size_id/', $attribute, $matches);
                    if (count($matches) >= 3) {
                        $itemIndex = $matches[1];
                        $productId = $this->input("items.$itemIndex.product_id");

                        $valid = DB::table('product_size')
                            ->where('product_id', $productId)
                            ->where('size_id', $value)
                            ->exists();

                        if (!$valid) {
                            $fail("The selected size does not belong to the selected product.");
                        }
                    }
                }
            ],
            'items.*.sizes.*.size_name' => 'required|string|max:50',
            'items.*.sizes.*.quantity' => 'required|integer|min:1',

            // Colors validation
            'items.*.colors' => 'required|array|min:1',
            'items.*.colors.*.color_id' => [
                'required',
                'exists:colors,id',
                function ($attribute, $value, $fail) {
                    preg_match('/items\.(\d+)\.colors\.(\d+)\.color_id/', $attribute, $matches);
                    if (count($matches) >= 3) {
                        $itemIndex = $matches[1];
                        $productId = $this->input("items.$itemIndex.product_id");

                        $valid = DB::table('product_color')
                            ->where('product_id', $productId)
                            ->where('color_id', $value)
                            ->exists();

                        if (!$valid) {
                            $fail("The selected color does not belong to the selected product.");
                        }
                    }
                }
            ],
            'items.*.colors.*.color_name' => 'required|string|max:50',
            'items.*.colors.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => 'Please enter the customer\'s full name.',
            'phone_number.required' => 'Please enter the customer\'s phone number.',
            'delivery_address.required' => 'Please enter a delivery address.',

            'items.required' => 'At least one product must be added to the order.',
            'items.min' => 'At least one product must be added to the order.',
            'items.*.product_id.required' => 'Please select a product.',
            'items.*.product_id.exists' => 'The selected product is invalid.',

            // Size messages
            'items.*.sizes.required' => 'Please select at least one size for each product.',
            'items.*.sizes.min' => 'Please select at least one size for each product.',
            'items.*.sizes.*.size_id.required' => 'Size ID is required.',
            'items.*.sizes.*.size_id.exists' => 'The selected size is invalid.',
            'items.*.sizes.*.size_name.required' => 'Size name is required.',
            'items.*.sizes.*.quantity.required' => 'Quantity is required for each size.',
            'items.*.sizes.*.quantity.integer' => 'Quantity must be a whole number.',
            'items.*.sizes.*.quantity.min' => 'Quantity must be at least 1.',

            // Color messages
            'items.*.colors.required' => 'Please select at least one color for each product.',
            'items.*.colors.min' => 'Please select at least one color for each product.',
            'items.*.colors.*.color_id.required' => 'Color ID is required.',
            'items.*.colors.*.color_id.exists' => 'The selected color is invalid.',
            'items.*.colors.*.color_name.required' => 'Color name is required.',
            'items.*.colors.*.quantity.required' => 'Quantity is required for each color.',
            'items.*.colors.*.quantity.integer' => 'Quantity must be a whole number.',
            'items.*.colors.*.quantity.min' => 'Quantity must be at least 1.',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('items')) {
            $items = collect($this->items)->filter(function ($item) {
                return !empty($item['product_id']) && (!empty($item['sizes']) || !empty($item['colors']));
            })->values();

            $items = $items->map(function ($item) {
                // Clean sizes
                $item['sizes'] = collect($item['sizes'] ?? [])->filter(function ($size) {
                    return !empty($size['size_id']) && $size['quantity'] > 0;
                })->values()->toArray();

                // Clean colors
                $item['colors'] = collect($item['colors'] ?? [])->filter(function ($color) {
                    return !empty($color['color_id']) && $color['quantity'] > 0;
                })->values()->toArray();

                return $item;
            })->filter(function ($item) {
                return !empty($item['sizes']) || !empty($item['colors']);
            })->values();

            $this->merge(['items' => $items->toArray()]);
        }
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        if ($this->has('items')) {
            foreach ($this->items as $itemIndex => $item) {
                if (!empty($item['product_id'])) {
                    $product = \App\Models\Product::find($item['product_id']);

                    if ($product) {
                        // Total quantity from sizes
                        $sizeQuantity = collect($item['sizes'] ?? [])->sum('quantity');

                        // Total quantity from colors
                        $colorQuantity = collect($item['colors'] ?? [])->sum('quantity');

                        $totalQuantity = $sizeQuantity + $colorQuantity;

                        if ($totalQuantity > $product->stock) {
                            $validator->errors()->add(
                                "items.$itemIndex.stock_exceeded",
                                "The requested quantity exceeds available stock for {$product->name}."
                            );
                        }

                        // You can add specific stock checks per color/size here if needed
                    }
                }
            }
        }

        parent::failedValidation($validator);
    }
}
