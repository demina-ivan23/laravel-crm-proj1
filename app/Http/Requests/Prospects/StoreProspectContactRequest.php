<?php

namespace App\Http\Requests\Prospects;

use Illuminate\Foundation\Http\FormRequest;

class StoreProspectContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone_number' => 'required|max:225',
            'facebook_account' => 'nullable|max:225',
            'instagram_account' => 'nullable|max:225',
            'address' => 'nullable|max:225',
            'personal_info' => 'nullable'
        ];
    }
}
