<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomFieldRequest extends FormRequest
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
        if(request()->isMethod('PATCH')) {
            return [
                'value' => 'string|required_without:file',
                'file' => 'sometimes|file',
            ];
        }

        return [
            'file' => 'sometimes|file',
            'name' => 'required',
            'value' => 'nullable|required_without:file'
        ];
    }
}
