<?php

namespace App\Http\Requests\Config;

use Illuminate\Foundation\Http\FormRequest;

class StationRequest extends FormRequest
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
          'connection_id'             => '',
          'name'                      => '',
          'name_table'                => '',
          'active'                    => '',
          'type'                      => '',
          'quantity_measurement_day'  => ''
        ];
    }
}
