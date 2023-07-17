<?php
namespace App\Http\Controllers\Backend\ProfileActivities\MpLeave;
use App\Http\Controllers\Controller;
use App\Model\HolidayReason;
use App\Model\MpLeaveApplication;
use App\Model\MpPs;
use App\Traits\ProfileTrait;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class LeaveApplicationController extends Controller{
    use ProfileTrait;

    public function index(){
        $data['user'] = authInfo();
        $where = [];
        if(authInfo()->usertype == 'ps'){
            $where[] = ['created_by', '=', authInfo()->id];
        }else if(authInfo()->usertype == 'mp') {
            $where[] = ['application_for', '=', authInfo()->id];
        }else{
            return redirect()->back()->with('error', Lang::get('Can Apply for MP or PS only!!!'));
        }
        //$data['allLeaves'] = MpLeaveApplication::with(['holiday_reasons'])->orderBy('updated_at','desc')->where($where)->get();
        $data['allLeaves'] = MpLeaveApplication::with(['holiday_reasons'])->orderBy('id','desc')->where($where)->get();
        foreach($data['allLeaves'] as $l){
            $l->total_leaves = round((strtotime($l->to_date)- strtotime($l->from_date)) / (60 * 60 * 24))+1;
            if($l->status==0){
                $l->status_name = \Lang::get('Waiting to send');
            }
            else if($l->status==1){
                $l->status_name = \Lang::get('Waiting for approval');
            }
            else if($l->status==2){
                $l->status_name = \Lang::get('Approved');
            }
            else if($l->status==3){
                $l->status_name = \Lang::get('Rejected');
            }
            else{
                $l->status_name = '';
            }
        }
        if (isApi()) {
            $response['status']    = 'success'; // return data
            $response['message']    = ''; // return data
            $response['api_info']    = $data; // return data
            return response()->json($response);
        }

        return view('backend.profileActivities.mp-leave.leave-application.index',$data);
    }

    public function create(){
        // $data['applied_date'] = MpLeaveApplication::where('application_for',authInfo()->id)->select(DB::raw('DISTINCT(from_date)'))->pluck('from_date')->toArray();
        // $data['to_date'] = MpLeaveApplication::where('application_for',authInfo()->id)->select(DB::raw('DISTINCT(to_date)'))->pluck('to_date')->toArray();

        $data['applied_date'] = [];
        $data['to_date'] = [];

        $applied_date = MpLeaveApplication::where('application_for',authInfo()->id)
        ->select('from_date', 'to_date')->get();
        foreach($applied_date as $applied_date){
            $period = CarbonPeriod::create($applied_date->from_date, $applied_date->to_date);
            foreach ($period as $date) {
                array_push($data['applied_date'], $date->format('Y-m-d')); 
                array_push($data['to_date'], $date->format('Y-m-d')); 
            }
        }
        // dd($data['applied_date']);
        // dd($data['to_date']);

        $data['holiday_reasons'] = HolidayReason::all();
        if (isApi()) {
            $response['status']    = 'success'; // return data
            $response['message']    = ''; // return data
            $response['api_info']    = $data; // return data
            return response()->json($response);
        }
        $data['user_type']=authInfo()->usertype;
        return view('backend.profileActivities.mp-leave.leave-application.form',$data);
    }

    public function store(Request $request){
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'from_date' => 'required',
            'to_date' => 'required',
            'holiday_reason_id' => 'required',
            'attach_file' => 'mimes:pdf,png,jpg,jpeg',
        ]);
        $message = [
            'from_date.required' => 'Please select From date.',
            'to_date.required' => 'Please select To date.',
            'holiday_reason_id.required' => 'Please select Leave Reason.',
        ];

        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];
    
        //$this->validate($request, $rules, $customMessages);
        
        if ($validator->fails()) {
            if (isApi()) {
                $response = [
                    'status'=> 'error',
                    'message'=>  $validator->messages(),
                ];
                return response()->json($response);
                //return response()->json($validator->messages(), 200);
            }
            return response()->json($validator->messages(), 200);
        }


        $submit_status = $request->mpsubmit;
        if ($submit_status ==1){
            $file = $request->attach_file;
            $hasAttachment = true;
            $attachement_file = '';

            if($file){
                $file_name = date('YmdHis').'_'.str_replace(' ','_',strtolower($file->getClientOriginalName()));
                if (!file_exists('public/backend/images/leave-file')) {
                    mkdir('public/backend/images/leave-file', 0777, true);
                }
                $upload_folder = 'public/backend/images/leave-file';
                $success = $file->move($upload_folder, $file_name);
                if($success){
                    $hasAttachment = true;
                    $attachement_file = $file_name;
                }else{
                    $hasAttachment = false;
                }
            }
            if($hasAttachment == false){
                $response = [
                    'status'=> 'error',
                    'message'=> "File Upload Failed, Please check your uploaded file",
                    'reload_url'=> route('admin.profile-activities.mp-leave.leave-application.index')
                ];
            }else {
                $mpLeaveApplication = new MpLeaveApplication();
                $mpLeaveApplication->from_date = date('Y-m-d', strtotime($request->from_date));
                $mpLeaveApplication->to_date = date('Y-m-d', strtotime($request->to_date));
                if(authInfo()->usertype == 'ps'){
                    $ps_of_mp_id = MpPs::where('ps_user_id', authInfo()->id)->get();
                    if(isset($ps_of_mp_id[0])){
                        $mpLeaveApplication->application_for =  $ps_of_mp_id[0]->mp_user_id;
                    }
                    $mpLeaveApplication->status = 0;
                }else{
                    $mpLeaveApplication->application_for = authInfo()->id;
                    $mpLeaveApplication->status = 1;
                }

                $mpLeaveApplication->holiday_reason_id = $request->holiday_reason_id;
                $mpLeaveApplication->note = $request->note;
                $mpLeaveApplication->updated_at = null;
                $mpLeaveApplication->submission_date = date('Y-m-d');
                // 1 for pending
                if($attachement_file){
                    $mpLeaveApplication->attach_file = $attachement_file;
                }
                $mpLeaveApplication->created_by = authInfo()->id;
                $result = $mpLeaveApplication->save();
                if($result){
                    if (isApi()) {
                        $response['status']    = 'success'; // return data
                        $response['message']  =  \Lang::get('Data Successfully Insert'); // return data
                        return response()->json($response);
                    }
                    $response = [
                        'status'=>'success',
                        'message'=> \Lang::get('Data Successfully Insert'),
                        'reload_url'=>route('admin.profile-activities.mp-leave.leave-application.index')
                    ];
                }else{
                    if (isApi()) {
                        $response['status']    = 'error'; // return data
                        $response['message']  =  \Lang::get('Data Insert Failed'); // return data
                        return response()->json($response);
                    }
                    //error save
                    $response = [
                        'status'=>'error',
                        'message'=> "Data Insert Failed",
                        'reload_url'=>route('admin.profile-activities.mp-leave.leave-application.create')
                    ];
                }
            }

        }else{
            $file = $request->attach_file;
            $hasAttachment = true;
            $attachement_file = '';

            if($file){
                $file_name = date('YmdHis').'_'.str_replace(' ','_',strtolower($file->getClientOriginalName()));
                if (!file_exists('public/backend/images/leave-file')) {
                    mkdir('public/backend/images/leave-file', 0777, true);
                }
                $upload_folder = 'public/backend/images/leave-file';
                $success = $file->move($upload_folder, $file_name);
                if($success){
                    $hasAttachment = true;
                    $attachement_file = $file_name;
                }else{
                    $hasAttachment = false;
                }
            }
            if($hasAttachment == false){
                $response = [
                    'status'=> 'error',
                    'message'=> "File Upload Failed, Please check your uploaded file",
                    'reload_url'=> route('admin.profile-activities.mp-leave.leave-application.index')
                ];
            }else {
                $mpLeaveApplication = new MpLeaveApplication();
                $mpLeaveApplication->from_date = date('Y-m-d', strtotime($request->from_date));
                $mpLeaveApplication->to_date = date('Y-m-d', strtotime($request->to_date));
                if(authInfo()->usertype == 'ps'){
                    $ps_of_mp_id = MpPs::where('ps_user_id', authInfo()->id)->get();
                    if(isset($ps_of_mp_id[0])){
                        $mpLeaveApplication->application_for =  $ps_of_mp_id[0]->mp_user_id;
                    }
                    $mpLeaveApplication->status = 0;
                }else{
                    $mpLeaveApplication->application_for = authInfo()->id;
                    $mpLeaveApplication->status = 0;
                }

                $mpLeaveApplication->holiday_reason_id = $request->holiday_reason_id;
                $mpLeaveApplication->note = $request->note;
                $mpLeaveApplication->updated_at = null;
                // 1 for pending
                if($attachement_file){
                    $mpLeaveApplication->attach_file = $attachement_file;
                }
                $mpLeaveApplication->created_by = authInfo()->id;
                $result = $mpLeaveApplication->save();
                if($result){
                    if (isApi()) {
                        $response['status']    = 'success'; // return data
                        $response['message']  =  \Lang::get('Data Successfully Insert'); // return data
                        return response()->json($response);
                    }
                    $response = [
                        'status'=>'success',
                        'message'=> \Lang::get('Data Successfully Insert'),
                        'reload_url'=>route('admin.profile-activities.mp-leave.leave-application.index')
                    ];
                }else{
                    if (isApi()) {
                        $response['status']    = 'error'; // return data
                        $response['message']  =  \Lang::get('Data Insert Failed'); // return data
                        return response()->json($response);
                    }
                    //error save
                    $response = [
                        'status'=>'error',
                        'message'=> "Data Insert Failed",
                        'reload_url'=>route('admin.profile-activities.mp-leave.leave-application.create')
                    ];
                }
            }
        }

        return response()->json($response);
    }


    public function edit($id ,Request $request){
        // $data['applied_date'] = MpLeaveApplication::where('application_for',authInfo()->id)->select(DB::raw('DISTINCT(from_date)'))->pluck('from_date')->toArray();
        // $data['to_date'] = MpLeaveApplication::where('application_for',authInfo()->id)->select(DB::raw('DISTINCT(to_date)'))->pluck('to_date')->toArray();

        $data['applied_date'] = [];
        $data['to_date'] = [];

        $applied_date = MpLeaveApplication::where('application_for',authInfo()->id)
        ->select('from_date', 'to_date')->get();
        foreach($applied_date as $applied_date){
            $period = CarbonPeriod::create($applied_date->from_date, $applied_date->to_date);
            foreach ($period as $date) {
                array_push($data['applied_date'], $date->format('Y-m-d')); 
                array_push($data['to_date'], $date->format('Y-m-d')); 
            }
        }

        $where = [];
        if(authInfo()->usertype == 'ps'){
            $where[] = ['application_for', '=', authInfo()->id];
        }else {
            $where[] = ['created_by', '=', authInfo()->id];

        }
        $data['editData'] = MpLeaveApplication::find($id);
        $data['holiday_reasons'] = HolidayReason::all();
        if (isApi()) {
            $response['status']    = 'success'; // return data
            $response['message']    = ''; // return data
            $response['api_info']    = $data; // return data
            return response()->json($response);
        }
        $data['user_type']=authInfo()->usertype;
        return view('backend.profileActivities.mp-leave.leave-application.form',$data);
    }

    //For sending
    public function updateMp(MpLeaveApplication $editData , Request $request){
        $validator = Validator::make($request->all(), [
            'from_date' => 'required',
            'to_date' => 'required',
            'attach_file' => 'mimes:pdf,png,jpg,jpeg',
        ]);
        if ($validator->fails()) {
            if (isApi()) {
                $response = [
                    'status'=> 'error',
                    'error'=> $validator->messages(),
                    'message'=>  $message="Data Not Found!!!"
                ];
                return response()->json($response);
            }
            return response()->json($validator->messages(), 200);
        }
        $file = $request->attach_file;
        $hasAttachment = true;
        $attachement_file = '';

        if($file){

            $file_name = date('YmdHis').'_'.str_replace(' ','_',strtolower($file->getClientOriginalName()));
            if (!file_exists('public/backend/images/leave-file')) {
                mkdir('public/backend/images/leave-file', 0777, true);
            }
            $upload_folder = 'public/backend/images/leave-file';
            $success = $file->move($upload_folder, $file_name);
            if($success){
                $hasAttachment = true;
                $attachement_file = $file_name;
            }else{
                $hasAttachment = false;
            }
        }

        if($hasAttachment == false){
            $response = [
                'status'=> 'error',
                'message'=> "File Upload Failed, Please check your uploaded file",
                'reload_url'=> route('admin.profile-activities.mp-leave.leave-application.index')
            ];
        }else {
            DB::beginTransaction();
            try {
                if($attachement_file){
                    @unlink('public/backend/images/leave-file/'.$editData->attach_file);
                    $params['attach_file'] = $attachement_file;
                }

                if(authInfo()->usertype == 'mp'){
                    $params['status'] = 1;
                }else {
                    $params['status'] = 0;
                }
                $params['from_date'] = date('Y-m-d', strtotime($request->from_date));
                $params['to_date'] = date('Y-m-d', strtotime($request->to_date));
                $params['note'] = $request->note;
                $params['holiday_reason_id'] = $request->holiday_reason_id;
                $params['updated_by'] = Auth::id();
                $editData->update($params);
                DB::commit();
                if (isApi()) {
                    $response['status']    = 'success'; // return data
                    $response['message']   = \Lang::get('Data Successfully Updated'); // return data
                    return response()->json($response);
                }
                $response = ['status'=>'success','message'=> Lang::get('Data Successfully Updated'), 'reload_url'=>route('admin.profile-activities.mp-leave.leave-application.index')];
            } catch (\Exception $e) {
                @unlink('public/backend/images/leave-file/'.$attachement_file);
                DB::rollback();
                if (isApi()) {
                    $response['status']    = 'error'; // return data
                    $response['message']   = \Lang::get('Data Update Failed'); // return data
                    return response()->json($response);
                }
                $response = ['status'=>'success','message'=> 'Data Update Failed', 'reload_url'=>route('admin.profile-activities.mp-leave.leave-application.index')];
            }

        }

        return response()->json($response);

    }

    public function show($id){
        $data['showData'] = MpLeaveApplication::find($id);
        if (isApi()) {
            $response['status']    = 'success'; // return data
            $response['message']    = ''; // return data
            $response['api_info']    = $data; // return data
            return response()->json($response);
        }

        return view('backend.profileActivities.mp-leave.leave-application.show',$data);
    }


    public function updateData(MpLeaveApplication $editData , Request $request){
        $validator = Validator::make($request->all(), [
            'from_date' => 'required',
            'to_date' => 'required',
            'attach_file' => 'mimes:pdf,png,jpg,jpeg',
        ]);
        if ($validator->fails()) {
            if (isApi()) {
                $response = [
                    'status'=> 'error',
                    'error'=> $validator->messages(),
                    'message'=>  $message = "Data Not Found!!!"
                ];
                return response()->json($response);
            }
            return response()->json($validator->messages(), 200);
        }


        $submit_status = $request->mpsubmit;
        if($submit_status ==1){

            $file = $request->attach_file;
            $hasAttachment = true;
            $attachement_file = '';

            if($file){
                $file_name = date('YmdHis').'_'.str_replace(' ','_',strtolower($file->getClientOriginalName()));
                if (!file_exists('public/backend/images/leave-file')) {
                    mkdir('public/backend/images/leave-file', 0777, true);
                }
                $upload_folder = 'public/backend/images/leave-file';
                $success = $file->move($upload_folder, $file_name);
                if($success){
                    $hasAttachment = true;
                    $attachement_file = $file_name;
                }else{
                    $hasAttachment = false;
                }
            }

            if($hasAttachment == false){
                $response = [
                    'status'=> 'error',
                    'message'=> "File Upload Failed, Please check your uploaded file",
                    'reload_url'=> route('admin.profile-activities.mp-leave.leave-application.index')
                ];
            }else {
                DB::beginTransaction();
                try {
                    if($attachement_file){
                        @unlink('public/backend/images/leave-file/'.$editData->attach_file);
                        $params['attach_file'] = $attachement_file;
                    }
                    //$submission_date = Carbon::now()->format('Y-m-d');
                    $params['status'] = 1;
                    $params['submission_date'] = date('Y-m-d');
                    $params['from_date'] = date('Y-m-d', strtotime($request->from_date));
                    $params['to_date'] = date('Y-m-d', strtotime($request->to_date));
                    $params['note'] = $request->note;
                    $params['holiday_reason_id'] = $request->holiday_reason_id;
                    $params['updated_by'] = Auth::id();

                    $editData->update($params);
                    DB::commit();
                    if (isApi()) {
                        $response['status']    = 'success'; // return data
                        $response['message']   = \Lang::get('Data Successfully Updated'); // return data
                        return response()->json($response);
                    }
                    $response = ['status'=>'success','message'=> Lang::get('Data Successfully Updated'), 'reload_url'=>route('admin.profile-activities.mp-leave.leave-application.index')];
                } catch (\Exception $e) {
                    @unlink('public/backend/images/leave-file/'.$attachement_file);
                    DB::rollback();
                    if (isApi()) {
                        $response['status']    = 'error'; // return data
                        $response['message']   = \Lang::get('Data Update Failed'); // return data
                        return response()->json($response);
                    }
                    $response = ['status'=>'success','message'=> 'Data Update Failed', 'reload_url'=>route('admin.profile-activities.mp-leave.leave-application.index')];
                }

            }
        } else{
            $file = $request->attach_file;
            $hasAttachment = true;
            $attachement_file = '';

            if($file){
                $file_name = date('YmdHis').'_'.str_replace(' ','_',strtolower($file->getClientOriginalName()));
                if (!file_exists('public/backend/images/leave-file')) {
                    mkdir('public/backend/images/leave-file', 0777, true);
                }
                $upload_folder = 'public/backend/images/leave-file';
                $success = $file->move($upload_folder, $file_name);
                if($success){
                    $hasAttachment = true;
                    $attachement_file = $file_name;
                }else{
                    $hasAttachment = false;
                }
            }

            if($hasAttachment == false){
                $response = [
                    'status'=> 'error',
                    'message'=> "File Upload Failed, Please check your uploaded file",
                    'reload_url'=> route('admin.profile-activities.mp-leave.leave-application.index')
                ];
            }else {
                DB::beginTransaction();
                try {
                    if($attachement_file){
                        @unlink('public/backend/images/leave-file/'.$editData->attach_file);
                        $params['attach_file'] = $attachement_file;
                    }

                    if(authInfo()->usertype == 'ps'){
                        $params['status'] = 0;
                    }else {
                        $params['status'] = 0;
                    }

                    $params['from_date'] = date('Y-m-d', strtotime($request->from_date));
                    $params['to_date'] = date('Y-m-d', strtotime($request->to_date));
                    $params['note'] = $request->note;
                    $params['holiday_reason_id'] = $request->holiday_reason_id;
                    $params['updated_by'] = Auth::id();
                    $editData->update($params);
                    DB::commit();
                    if (isApi()) {
                        $response['status']    = 'success'; // return data
                        $response['message']   = \Lang::get('Data Successfully Updated'); // return data
                        return response()->json($response);
                    }
                    $response = ['status'=>'success','message'=> Lang::get('Data Successfully Updated'), 'reload_url'=>route('admin.profile-activities.mp-leave.leave-application.index')];
                } catch (\Exception $e) {
                    @unlink('public/backend/images/leave-file/'.$attachement_file);
                    DB::rollback();
                    if (isApi()) {
                        $response['status']    = 'error'; // return data
                        $response['message']   = \Lang::get('Data Update Failed'); // return data
                        return response()->json($response);
                    }
                    $response = ['status'=>'success','message'=> 'Data Update Failed', 'reload_url'=>route('admin.profile-activities.mp-leave.leave-application.index')];
                }

            }
        }


        return response()->json($response);
    }


    public function cheackDate(){
        //where::('mp_id',authInfo()->id)->pluck('date')->toArray()
        //LeaveModel::whereInBetween('date',$start,$end)->pluck('date')->toArray()
    }



    public function destroy($id){
        try {
            $Mpleave = MpLeaveApplication::find($id);
            $image_path = "public/backend/images/leave-file/".$Mpleave->attach_file;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $Mpleave->deleted_by = authInfo()->id;
            $Mpleave->delete();
            if (isApi()) {
                $response['status']    = 'error'; // return data
                $response['message']  =  \Lang::get('Data Update Failed'); // return data
                return response()->json($response);
            }
            return response()->json(["status"=>"success"]);
        } catch (\Exception $e) {
             // $errorMessage=$e->getMessage();
            $customMessage="Exception! Something went wrong please try again!";
            Session::flash('error', $customMessage, true);
            return response()->json(['status'=>'error']);
        }
    }


}
