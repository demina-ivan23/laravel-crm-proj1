<?php

namespace App\Http\Requests\Prospects;

use Illuminate\Foundation\Http\FormRequest;

class StoreProspectRequest extends FormRequest
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
        $emailRule = 'max:225|unique:prospects,email,' . $this->route('prospect')->id;
        $smalltext = 'string|max:225';
        return [
            'name' => 'required|'.$smalltext,
            'email' => $emailRule,
            'phone_number' => 'string|min:8|max:12',
            'facebook_account' => $smalltext,
            'instagram_account' => $smalltext,
            'address' => $smalltext,
            'personal_info' => 'string',
            'prospect_state' => 'required|integer|exists:prospect_states,id',
            'prospect_state_explanation' => 'string|max:1000'
        ];
    }
}
