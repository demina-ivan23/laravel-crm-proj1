<?php

namespace App\Http\Requests\Superadmin\OrderStatus;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if(auth()->user()->is_superadmin)
        {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'string|min:3|max:225',
            'description' => 'string|min:3|max:225',
            'first_step_status' => 'boolean',
            'can_transit_into' => 'string|min:3|max:1000|nullable',
        ];
    }
}
