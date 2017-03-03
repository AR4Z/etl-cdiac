<?php

namespace App\Http\Requests\Config;

use Illuminate\Foundation\Http\FormRequest;

class VariableRequest extends FormRequest
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
          'name'            =>'',
          'name_excel'      =>'',
          'name_database'   =>'',
          'name_locale'     =>''
        ];
    }
}
