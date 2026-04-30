<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderStatusRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->is_admin === true; }
    public function rules(): array
    {
        return ['status' => ['required', 'string', Rule::in(['pending', 'preparing', 'ready', 'delivered', 'cancelled'])]];
    }
}
