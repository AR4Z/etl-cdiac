<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EtlPlaneRequest extends FormRequest
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
            'net_name'      =>'required',
            'station_id'    =>'required',
            'method'        =>'required',
            'sequence'      =>'',
            'jobs'=>'',
            'serialization' =>'',
            'trust_process' =>'',
            'file'          =>'required|mimes:csv,txt',
        ];
    }
}
