<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'client_name' => ['required', 'string', 'min:2', 'max:120'],
            'phone' => ['required', 'string', 'regex:/^\+?\d{8,20}$/'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
    protected function prepareForValidation(): void
    {
        $phone = is_string($this->phone) ? preg_replace('/\s+/', '', $this->phone) : $this->phone;
        $notes = is_string($this->notes) ? trim(strip_tags($this->notes)) : null;
        $this->merge(['phone' => $phone, 'notes' => $notes ?: null]);
    }
}
