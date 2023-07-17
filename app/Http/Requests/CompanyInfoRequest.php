<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Lang;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class CompanyInfoRequest extends FormRequest
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
            'company_name_english' => 'required',
            'company_name_bangla' => 'required',
            'company_add_english' => "required",
            'company_add_bangla' => "required",
            'company_phone' => "required"
        ];
    }

    public function messages()
    {
        return [
            'company_name_english.required' => Lang::get('This field is required.'),
            'company_name_bangla.required'  => Lang::get('This field is required.'),
            'company_add_english.required'  => Lang::get('This field is required.'),
            'company_add_bangla.required'   => Lang::get('This field is required.'),
            'company_phone.required'        => Lang::get('This field is required.'),
        ];
    }
    protected function failedValidation(Validator $validator)
    {

        // $json = [
        //     'status' => 'Ops! Some errors occurred',
        //     'errors' => $validator->errors()
        // ];
        // $response = new JsonResponse($json, 400);
        // throw (new ValidationException($validator, $response))->status(400);
        if ($this->wantsJson() && $validator->fails()) {
            // dd('okk iam');
            $response = response()->json([
                'status' => 400,
                'errors' => $validator->errors() //$validator->errors()
            ]);
        } else if ($validator->fails()) {
            // dd('okk');
            $response = redirect()
                ->route('login')
                ->with('message', 'Ops! Some errors occurred')
                ->withErrors($validator);
        }
        throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
