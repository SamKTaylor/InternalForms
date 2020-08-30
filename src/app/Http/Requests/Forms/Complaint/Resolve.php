<?php

namespace App\Http\Requests\Forms\Complaint;

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
            'id'                    => 'required|exists:complaints,id',
            'resolved_by'           => 'required|exists:users,id',
            'root_cause'            => 'required',
            'corrective_action'     => 'required',
            'preventative_action'   => 'required',
        ];
    }
}
