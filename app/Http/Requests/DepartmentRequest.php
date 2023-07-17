<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Lang;

class DepartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return [

           // 'name' =>'required',
             'name' =>[
                 'required',
                 Rule::unique('departments')->ignore($request->id, 'id'),
             ],
            'name_bn' =>'required',

        ];
    }

    public function messages() {
        return [
            'name.required' => \Lang::get('English name field is required!'),
            'name_bn.required' => \Lang::get('Bangla name field is required!'),
            'name.unique' => \Lang::get('Name already exists!'),
        ];
    }
}
