<?php

namespace App\Http\Controllers\Backend\ProfileActivities;

use App\Model\FileCategory;
use App\Model\FileShare;
use App\Model\Profile;
use App\Model\FileInfo;
use App\Model\MpPs;
use App\Traits\FileInfoTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Lang;

class FileInfoController extends Controller
{
    use FileInfoTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (authInfo()->usertype == 'ps') {
            $mp_user_id = MpPs::select('mp_user_id')->where('ps_user_id', authInfo()->id)->first();
            if ($mp_user_id) {
                $fileInfo = FileInfo::where('created_by', authInfo()->id)
                ->orWhere('created_by', $mp_user_id->mp_user_id)->get();
                $mp_role = DB::table('user_roles')->where('user_id', $mp_user_id->mp_user_id)->first();
                if ($mp_role) {
                    $fileSize = DB::table('file_allowances')->where('role_id', $mp_role->role_id)->first();
                }
            }
        } else if (authInfo()->usertype != 'ps') {
            $ps_user_id = MpPs::select('ps_user_id')->where('mp_user_id', authInfo()->id)->first();
            if ($ps_user_id) {
                $fileInfo = FileInfo::where('created_by', authInfo()->id)
                ->orWhere('created_by', $ps_user_id->ps_user_id)->get();
            } else {
                $fileInfo = FileInfo::where('created_by', authInfo()->id)->get();
            }
            $mp_role = DB::table('user_roles')->where('user_id', authInfo()->id)->first();
            $role_arr = array(8,9);
            if (in_array($mp_role->role_id, $role_arr)) {
                $fileSize = DB::table('file_allowances')->where('role_id', $mp_role->role_id)->first();
            }else{
                return redirect()->route('dashboard')->with('error', Lang::get('You are not allowed on this menu!'));
            }
        }

        $fileSizesum = 0;
        foreach($fileInfo as $file){
            $fileSizesum += (int)$file->file_size;
        }

        $totalLimitMB = (int)$fileSize->total_allowance;
        $each_file_limit = (int)$fileSize->each_file_size;
        $data['each_file_limit'] = $each_file_limit;

        $data['totalLimitMB'] = $totalLimitMB;
        $totalLimitMBKb = 1000000 * $totalLimitMB;
        $TLimitMB = 200;
        $data['tAllowance'] = $totalLimitMB;

        $fileSizesumMb = number_format($fileSizesum / 1048576, 2);

        if($fileSizesumMb !=0){
            $tUsed = $fileSizesumMb;
        }else{
            $tUsed = 0;
        }
        $data['tUsed'] = round($tUsed,2);

        $dueSpace = $totalLimitMB - $fileSizesumMb;
        $data['dueSpace'] = $dueSpace;

        if($fileSizesumMb ==''){
            $percent = '0%';
            $data['complete'] = round($percent,2);
        }else{
            $percent = (($fileSizesumMb / $totalLimitMB) * 100).'%';
            $data['complete'] = round($percent,2);
        }

        $data['allData'] = $fileInfo;
        $fileSize = DB::table('file_allowances')->first();
        $totalLimitMB = (int)$fileSize->total_allowance;
        $totalLimitMBKb = 1000000 * $totalLimitMB;

        $sharedFileId = FileShare::select('file_info_id')->where('share_with', Auth::id())->get();
        $shareFileArr = array();
        foreach($sharedFileId as $fileId){
            $shareFileArr[] = $fileId->file_info_id;
        }

        $data['ownShared'] = FileInfo::whereIn('id', $shareFileArr)->get();
        $style = 'width:'.$percent.';background-color:#1A73E8;height:15px;border-radius:15px;';
        $data['style'] = $style;


        return view('backend.profileActivities.file-info.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (authInfo()->usertype == 'ps') {
            $mp_user_id = MpPs::select('mp_user_id')->where('ps_user_id', authInfo()->id)->first();
            if ($mp_user_id) {
                $mp_role = DB::table('user_roles')->where('user_id', $mp_user_id->mp_user_id)->first();
                if ($mp_role) {
                    $fileSize = DB::table('file_allowances')->where('role_id', $mp_role->role_id)->first();
                }
            }
        } else if (authInfo()->usertype != 'ps') {
            $mp_role = DB::table('user_roles')->where('user_id', authInfo()->id)->first();
            if ($mp_role) {
                $fileSize = DB::table('file_allowances')->where('role_id', $mp_role->role_id)->first();
            }
        }

        $each_file_limit = (int)$fileSize->each_file_size;
        $data['each_file_limit'] = $each_file_limit;
        return view('backend.profileActivities.file-info.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fileinfo = $this->creationFile($request);
        if ($fileinfo['status'] == 'success') {
            return redirect()->route('admin.profile-activities.file-info.index')->with('success', 'File Successfully created');
        } else {
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function singleFileView($id){
        $data['fileData'] = FileInfo::where('id',$id)->first();

        return view('backend.profileActivities.file-info.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['editData'] = $this->getFile($id);
        if (authInfo()->usertype == 'ps') {
            $mp_user_id = MpPs::select('mp_user_id')->where('ps_user_id', authInfo()->id)->first();
            if ($mp_user_id) {
                $mp_role = DB::table('user_roles')->where('user_id', $mp_user_id->mp_user_id)->first();
                if ($mp_role) {
                    $fileSize = DB::table('file_allowances')->where('role_id', $mp_role->role_id)->first();
                }
            }
        } else if (authInfo()->usertype != 'ps') {
            $mp_role = DB::table('user_roles')->where('user_id', authInfo()->id)->first();
            if ($mp_role) {
                $fileSize = DB::table('file_allowances')->where('role_id', $mp_role->role_id)->first();
            }
        }

        $each_file_limit = (int)$fileSize->each_file_size;
        $data['each_file_limit'] = $each_file_limit;
        return view('backend.profileActivities.file-info.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($id);
        $fileinfo = $this->creationFile($request, $id);
        if ($fileinfo['status'] == 'success') {
            return redirect()->route('admin.profile-activities.file-info.index')->with('success', 'File Updated Successfully');
        } else {
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $fileData = FileShare::where('file_info_id',$id)->get();
            if(count($fileData)>1){
                return $arr = array(
                    'status'=>'shared'
                );
            }else{
                $fileInfo = FileInfo::find($id);

                $folder = public_path( '/backend/file_category_name/' );
                @unlink( $folder . $fileInfo->attachment );

                $statusDelete = $fileInfo->delete();
                if($statusDelete){
                    $array = array(
                    'status'=> 0,
                    'deleted_by'=>authInfo()->id
                    );
                    $fileInfo->update($array);
    
                    // return response()->json(['status'=>'success']);
                    return response()->json(["status"=>"success","message"=>Lang::get('Data has been deleted!')]);
                    }else{
                    return response()->json(['status'=>'error']);
                }
            }
        } catch (\Exception $e) {
            $errorMessage=$e->getMessage();
            $customMessage="Exception! Something went wrong please try again!";
            \Session::flash('error', $errorMessage, true);
            return response()->json(["status"=>"error"]);
        }
    }


    public function fileDeleteAction(Request $request)
    {
        $fileData = FileShare::where('file_info_id',$request->id)->get();
        if(count($fileData)>1){
            return $arr = array(
                'status'=>'shared'
            );
        }else{
            $fileInfo = FileInfo::find($request->id);
            $statusDelete = $fileInfo->delete();
            if($statusDelete){
                $array = array(
                'status'=> 0,
                'deleted_by'=>authInfo()->id
                );
                $fileInfo->update($array);

                // return response()->json(['status'=>'success']);
                return response()->json(["status"=>"success","message"=>Lang::get('Data has been deleted!')]);
                }else{
                return response()->json(['status'=>'error']);
            }
        }
    }
}