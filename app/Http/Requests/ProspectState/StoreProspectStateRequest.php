<?php

namespace App\Http\Requests\ProspectState;

use Illuminate\Foundation\Http\FormRequest;

class StoreProspectStateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if(auth()->check() && auth()->user()->role->permissions->contains('prospect_state-write-web')){
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
            'title' => 'required|string|min:3|max:225',
            'description' => 'string|min:3|max:225',
            'can_transit_into[]' => 'array'
        ];
    }
}
