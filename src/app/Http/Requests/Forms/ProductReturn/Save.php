<?php

namespace App\Http\Requests\Forms\ProductReturn;

use Illuminate\Foundation\Http\FormRequest;

class Save extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_name'         => 'required',
            'issue'                 => 'required',
            'first_contact_date'    => 'required',
            'order_number'          => 'required'
        ];
    }
}
