<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->is_admin === true; }
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:200'],
            'subtitle' => ['nullable', 'string', 'max:2000'],
            'slug' => ['nullable', 'string', 'alpha_dash:ascii', 'max:200', 'unique:products,slug'],
            'description' => ['nullable', 'string', 'max:8000'],
            'price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $price = (string) $this->input('price', '');
        $normalizedPrice = str_replace([' ', ','], ['', '.'], trim($price));

        $slugInput = trim((string) $this->input('slug', ''));
        $nameInput = trim((string) $this->input('name', ''));

        $this->merge([
            'price' => $normalizedPrice,
            'slug' => $slugInput !== '' ? $slugInput : ($nameInput !== '' ? Str::slug($nameInput) : null),
        ]);
    }
}
