<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
            'allergie' => ['nullable', 'string', 'max:2000'],
            'personalization' => ['nullable', 'string', 'max:2000'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'allergie' => $this->sanitize($this->input('allergie')),
            'personalization' => $this->sanitize($this->input('personalization')),
        ]);
    }

    private function sanitize(mixed $value): ?string
    {
        if (!is_string($value)) return null;
        $v = trim(strip_tags($value));
        return $v === '' ? null : mb_substr($v, 0, 2000);
    }
}
