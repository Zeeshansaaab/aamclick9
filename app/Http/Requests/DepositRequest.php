<?php

namespace App\Http\Requests;

use App\Models\Gateway;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DepositRequest extends FormRequest
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
        $method = Gateway::find(request()->method_id);
        if(!$method){
            return [
                'method_id' => ['required'],
            ];
        }
        return [
            'deposit_type'   => ['required'],
            'amount'         => ['required', 'numeric', 'min:' . $method->min_amount, 'max:' . $method->max_amount]
        ];
    }

    public function messages()
   {
        return [
            'method_id.required' => 'Please select a payment method',
            'deposit_type.required' => 'Please select deposit type'
        ];
    }
}
