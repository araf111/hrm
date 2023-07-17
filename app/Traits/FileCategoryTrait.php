<?php

namespace App\Traits;

use App\User;
use App\Model\FileCategory;
use App\Model\MpPs;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

trait FileCategoryTrait
{
    public function all()
    {
        if(authInfo()->usertype == 'ps'){
            $mp_user_id = MpPs::select('mp_user_id')->where('ps_user_id', authInfo()->id)->first();
            if($mp_user_id){
            return $allCategory = FileCategory::where('created_by', authInfo()->id)
            ->orWhere('created_by', $mp_user_id->mp_user_id)->get();
        }
        }else if(authInfo()->usertype != 'ps'){
            $ps_user_id = MpPs::select('ps_user_id')->where('mp_user_id', authInfo()->id)->first();
            if($ps_user_id){
            return $allCategory = FileCategory::where('created_by', authInfo()->id)
            ->orWhere('created_by', $ps_user_id->ps_user_id)->get();
            }else{
            return $allCategory = FileCategory::where('created_by', authInfo()->id)->get();
            }
        }
    }

    public function getCategory($id)
    {
        return FileCategory::find($id);
    }

    protected function validateFileCategory($request)
    {

        $rules = [
            // 'category_name_bn' => 'required|unique:file_categories',
            // 'category_name_en' => 'required|unique:file_categories',
            'category_name_bn' =>[
                'required',
                Rule::unique( 'file_categories', 'category_name_bn' )->ignore($request->id, 'id')->where( function ( $query ) {
                    return $query->where( 'created_by', authInfo()->id );
                } )
            ],
            'category_name_en' =>[
                'required',
                Rule::unique( 'file_categories', 'category_name_en' )->ignore($request->id, 'id')->where( function ( $query ) {
                    return $query->where( 'created_by', authInfo()->id );
                } )
            ],
        ];
        
        $message = [
            'category_name_bn.required' => 'This field is required.',
            'category_name_en.required' => 'This field is required.',
            'category_name_bn.unique' => 'Name Already Exist!',
            'category_name_en.unique' => 'Name Already Exist!',
        ];
        
        return $this->validate($request, $rules, $message);

    }
    protected function validateFileCategoryUpdate($request, $id)
    {
               
        $rules = [
            // 'category_name_bn' =>'required|unique:file_categories,file_categories.category_name_bn,'.$id, 
            // 'category_name_en' =>'required|unique:file_categories,file_categories.category_name_en,'.$id, 
            'category_name_bn' =>[
                'required',
                Rule::unique( 'file_categories', 'category_name_bn' )->ignore($id, 'id')->where( function ( $query ) {
                    return $query->where( 'created_by', authInfo()->id );
                } )
            ],
            'category_name_en' =>[
                'required',
                Rule::unique( 'file_categories', 'category_name_en' )->ignore($id, 'id')->where( function ( $query ) {
                    return $query->where( 'created_by', authInfo()->id );
                } )
            ],
        ];
        $message = [
            'category_name_bn.required' => 'This field is required.',
            'category_name_en.required' => 'This field is required.',

            'category_name_bn.unique' => 'Name Already Exist!',
            'category_name_en.unique' => 'Name Already Exist!',
        
        ];

        return $this->validate($request, $rules, $message);
    }

    public function creationCategory($request, $id = null)
    {

        if ($id) {

            $this->validateFileCategoryUpdate($request, $id);

        }else{
            $this->validateFileCategory($request);
        }
        
        $returnResult = [];

        DB::beginTransaction();
        try {
            $params = $request->all();
            if ($id) {
                $category = FileCategory::find($id);
                $params['mp_id'] = Auth::id();;
                $params['updated_by'] = Auth::id();

                $category->update($params);
            }else{
                $params['mp_id'] = Auth::id();
                $params['created_by'] = Auth::id();
                $category = FileCategory::create($params);
            }
            DB::commit();
            $returnResult['status'] = true;
            $returnResult['data']   = $category;
        } catch (\Throwable $th) {
            DB::rollback();
            $returnResult['status']  = false;
            $returnResult['message'] = $th->getMessage();
            dd($returnResult);
        }

        return $returnResult;
    }
}