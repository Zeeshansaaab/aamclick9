<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstallmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'phone' => ['required', 'regex:/[0-9]{11}/'],
            'email' => 'required | email',
            'amount' => 'required |numeric| min:1',
            'image' => 'required|image',
            'address' => 'required',
        ];
    }
}
