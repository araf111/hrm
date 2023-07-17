<?php

namespace App\Traits;

use App\User;
use App\Model\FileShare;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

trait FileShareTrait
{
    public function all()
    {
        return FileCategory::all();
    }

    public function getCategory($id)
    {
        return FileCategory::find($id);
    }

    protected function validateFileCategory($request)
    {
        $rules = [
            'category_name_bn' => 'required',
            'category_name_en' => 'required',
        ];

        return $this->validate($request, $rules);
    }

    public function creationCategory($request, $id = null)
    {

        $this->validateFileCategory($request);
        $returnResult = [];

        DB::beginTransaction();
        try {
            $params = $request->all();
            if ($id) {
                $category = FileCategory::find($id);
                $params['status'] = $request->status ?? 0;
                $params['mp_id'] = authInfo()->id;
                $params['updated_by'] = authInfo()->id;
                $category->update($params);
            }else{
                $params['status'] = 1;
                $params['mp_id'] = authInfo()->id;
                $params['created_by'] = authInfo()->id;
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