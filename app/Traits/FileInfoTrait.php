<?php

namespace App\Traits;

use App\User;
use App\Model\FileInfo;
use App\Model\Profile;
use App\Model\MpPs;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

trait FileInfoTrait
{

    public function all()
    { }

    public function getFile($id)
    {
        return FileInfo::find($id);
    }

    protected function validateFile($request)
    {
        $rules = [
            'file_name' => 'required|unique:file_infos',
            'file_category_id' => 'required'
        ];

        return $this->validate($request, $rules);
    }


    public function creationFile($request, $id = null)
    {
        $returnResult = [];

        if (authInfo()->usertype == 'ps') {
            $mp_user_id = MpPs::select('mp_user_id')->where('ps_user_id', authInfo()->id)->first();
            $userid = Profile::select('user_id')->where('user_id', $mp_user_id->mp_user_id)->first();
            $user_id = $userid->user_id;
        } else if (authInfo()->usertype != 'ps') {
            $userid = Profile::select('user_id')->where('user_id', authInfo()->id)->first();
            if ($userid) {
                $user_id = $userid->user_id;
            } else {
                $userid = User::select('id')->where('id', authInfo()->id)->first();
                $user_id = $userid->id;
            }
        }

        $mp_role = DB::table('user_roles')->where('user_id', $user_id)->first();

        if ($id) {
            $rules = [
                'attachment' => 'required|file|max:10240|mimes:xlsx,xls,csv,jpg,jpeg,png,bmp,doc,docx,pdf,tif,tiff',
                'file_name' => 'required',
                'file_category_id' => 'required',
            ];
        }else{
            $rules = [
                'attachment' => 'required|file|max:10240|mimes:xlsx,xls,csv,jpg,jpeg,png,bmp,doc,docx,pdf,tif,tiff',
                'file_name' => 'required|unique:file_infos',
                'file_category_id' => 'required',
            ];
        }



        $customMessages = ([
            'file_name.required' => 'The File Name is required.',
            'file_category_id.required' => 'The Category Name is required.',
            'attachment.required' => 'Please upload an image.',
            'attachment.mimes' => 'Only xlsx, xls, csv, jpg, jpeg, png, bmp, doc, docx, pdf, tif, tiff images are allowed',
        ]);

        $this->validate($request, $rules, $customMessages);

        $attachmentSize = $request->file('attachment')->getSize();

        $fileSize = DB::table('file_allowances')->where('role_id', $mp_role->role_id)->first();
        $fileSizesum = FileInfo::where('mp_id', $user_id)->sum('file_size');

        $limitMB = (int)$fileSize->each_file_size;
        $totalLimitMB = (int)$fileSize->total_allowance;

        $limit = 1000000 * $limitMB;
        $totalLimitMBKb = 1000000 * $totalLimitMB;

        $fileSize = number_format($attachmentSize / 1048576, 2);
        $fileLimit = number_format($limit / 1048576, 2);

        $file_size_sum = number_format($fileSizesum / 1048576, 2);
        $TLimitMB = number_format($totalLimitMBKb / 1048576, 2);


        if ($file_size_sum >= $TLimitMB) {
            $customMessage = Lang::get('Total file size exceeds 200MB, you can no longer add files!');
            Session::flash('error', $customMessage, true);
            return array("status" => "error");
        }

        if ($fileSize > $fileLimit) {
            $customMessage = Lang::get('File size exceeds 10MB, please adjust the file size.');
            Session::flash('error', $customMessage, true);
            return array("status" => "error");
        }

        DB::beginTransaction();
        try
        {
            $params = $request->all();

            if ($id){
                $fileinfo = FileInfo::find($id);
                $params['mp_id'] = $user_id;
                $params['updated_by'] = authInfo()->id;

                if ($request->hasfile('attachment')) {
                    $path = public_path().'/backend/file_category_name/';
                    if($fileinfo->attachment != '' && $fileinfo->attachment != null){
                        $file_old = $path.$fileinfo->attachment;
                        unlink($file_old);
                    }
                    $files = $request->file('attachment');
                    $orginalFileName = $files->getClientOriginalName();
                    $filename = time() . random_int(0, 1000).'-' .$orginalFileName;
                    $path_text = $path . $filename;
                    $files->move('public/backend/file_category_name/', $filename);
                    $params['attachment'] = $filename;
                    $params['file_size'] = File::size($path_text);
                }
                    $fileinfo->update($params);
            }else{
                    if($request->hasfile('attachment')) {
                        $files = $request->file('attachment');
                        $path = public_path() . '/backend/file_category_name/';
                        $orginalFileName = $files->getClientOriginalName();
                        $filename = time() . random_int(0, 1000).'-' .$orginalFileName;
                        $path_text = $path. $filename;
                        $files->move('public/backend/file_category_name/', $filename);
                    }
                        $params['mp_id'] = $user_id;
                        $params['created_by'] = authInfo()->id;
                        $params['create_datetime'] = Carbon::now();
                        $params['attachment'] = $filename;
                        $params['file_size'] = File::size($path_text);
                        $file_size = File::size($path_text);
                        // dd($file_size);
                        $fileinfo = FileInfo::create($params);
                }

            DB::commit();
            return array("status" => "success");
        }catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            dd($errorMessage);
            $customMessage = "Exception! Something went wrong please try again!";
            Session::flash('error', $customMessage, true);
            return array("status" => "error");
        }

        return $returnResult;
    }
}