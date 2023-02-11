<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'           => ['required_without:address', 'string', 'max:255'],
            'country_code'   => ['required_without:address', 'min:2', 'max:2'],
            'mobile'         => ['required_without:address', 'regex:/[0-9]{10}/'],
        ];
    }

    public function messages(){
        return [
            'name.required_without' => "Name is required",
            'country_code.required_without' => "Country code is required",
            'mobile.required_without' => "Mobile number is required",
        ];
    }
}
