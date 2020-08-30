<?php

namespace App\Http\Requests\Forms\Complaint;

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
            'complaint_date'    => 'required',
            'received_by'       => 'required|exists:users,id',
            'receipt_type'      => 'required',
            'customer_name'     => 'required',
            'description'       => 'required',
            'category'          => 'required',
            'department'        => 'required',
            'assigned_to'       => 'required|exists:users,id',
            'insulation'        => 'status',
        ];
    }
}
