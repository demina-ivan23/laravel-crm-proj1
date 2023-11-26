<?php

namespace App\Http\Requests\Prospects;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProspectRequest extends FormRequest
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
        $emailRule = 'required|unique:prospects,email,' . $this->route('prospect');

        return [
            'name' => 'required',
            'email' => $emailRule,
            'profile_image' => 'nullable|mimes:img,jpg,jpeg,png|max:2000'
        ];
    }
}
