<?php

namespace App\Http\Requests\Forms\ProductReturn;

use Illuminate\Foundation\Http\FormRequest;

class Resolve extends FormRequest
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
            'closed_date'    => 'required',
            'further_action' => 'required',
        ];
    }
}
