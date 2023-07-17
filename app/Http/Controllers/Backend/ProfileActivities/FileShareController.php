<?php

namespace App\Http\Controllers\Backend\ProfileActivities;

use App\Traits\FileShareTrait;
use App\Model\FileShare;
use App\Model\FileInfo;
use App\Model\Profile;
use App\Model\Constituency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FileShareController extends Controller
{
    use FileShareTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['allData'] = $this->all();

        return view('backend.profileActivities.file-share.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.profileActivities.file-share.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fileCategory = $this->creationCategory($request);
        if ($fileCategory['status'] == true) {
            return redirect()->back()->with('success', 'Successfully created');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['editData'] = $this->getCategory($id);
        return view('backend.profileActivities.file-share.create', $data);
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
        $fileCategory = $this->creationCategory($request, $id);

        if ($fileCategory['status'] == true) {
            return redirect()->back()->with('success', 'Successfully updated');
        } else {
            dd($fileCategory['message']);
            return redirect()->back()->with('error', $fileCategory['message']);
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
        //
    }

    public function singleFileShare($share_id){

        // dd($share_id);

        $auth_id = authInfo()->id;
        $Data['singleData'] = FileInfo::where('id',$share_id)->first();
        $inData = FileShare::select('share_with')->where('file_info_id',$share_id)->get();
        $Data['allMemberData'] = Profile::all();
        $share_arr = array();

        foreach($inData as $data){
            $share_arr[] = $data->share_with;
        }

        $Data['share_id'] = $share_id;
        $Data['mpData'] = Profile::whereIn('user_id', $share_arr)->get();

        return view('backend.profileActivities.file-share.index', $Data);
    }

    /**
     * Remove the specified shared file from storage.
     *
     */
    public function shareInfoEntry(Request $request, $id){


        $fileId = FileInfo::where('id',$id)->first();
        $fileshare = FileShare::where('file_info_id',$id)->first();
        // dd($fileshare);
        try {

        if(!empty($fileshare)){
            // dd('hi');
            if($fileshare->file_info_id == $id && $fileshare->share_with == $request->mp_id){
            return redirect(route('admin.profile-activities.file-share',$fileId->id))->with('success','Already Shared This File');
            }else{

                FileShare::create([
                    'file_info_id' => $fileId->id,
                    'share_with' => $request->mp_id,
                    'created_by' => authInfo()->id,
                    'status' => 1,
                ]);

                return redirect(route('admin.profile-activities.file-share',$fileId->id))->with('success','Share Create Successfully');
            }
        }else{
            // dd($id.'tai');
            FileShare::create([
                    'file_info_id' => $fileId->id,
                    'share_with' => $request->mp_id,
                    'created_by' => authInfo()->id,
                    'status' => 1,
                ]);
            return redirect(route('admin.profile-activities.file-share',$fileId->id))->with('success','Share Create Successfully');
        }

        } catch (\Exception $e){
            dd($e->getMessage());
            return back()->with('alert',$e->getMessage());
        }
    }

    /**
     * Remove the specified shared file from storage.
     *
     */

    public function shareInfoDelete(Request $request, $id){

        $mp_id = $request->mp_id;

        $fileId = FileInfo::where('id',$id)->first();
        $fileshareId = FileShare::where('file_info_id',$id)->where('share_with',$mp_id)->first();
        try {
                if($fileshareId->file_info_id == $id && $fileshareId->share_with == $mp_id){
                    $iid = $fileshareId->id;
                    $fileShare = FileShare::find($iid);
                    $status = $fileShare->delete();
                    if($status){
                        $array = array(
                        'status'=> 0,
                        'deleted_by'=>authInfo()->id
                        );

                        $fileShare->update($array);

                    }
                return response()->json(["status" => "success"]);
            }

        } catch (\Exception $e){
            $errorMessage = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            Session::flash('error', $customMessage, true);
            return response()->json(['status' => 'error']);
        }
    }

}
