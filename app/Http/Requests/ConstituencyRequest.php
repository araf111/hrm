<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Lang;

class ConstituencyRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {

        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules( Request $request ) {
        return [

            'name'             => 'required',
            'bn_name'          => 'required',
            'number'           => 'required|numeric',
            'parliamentNumber' => 'required|numeric',

        ];
    }

    public function messages() {
        return [
            'name.required'             => \Lang::get('English name field is required!'),
            'bn_name.required'          => \Lang::get('Bangla name field is required!'),
            'number.required'           => \Lang::get('Number field is required!'),
            'parliamentNumber.required' => \Lang::get('Parliament number field is required!'),

        ];
    }
}
