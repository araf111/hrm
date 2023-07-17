<?php

namespace App\Http\Controllers\Backend\ProfileActivities\MpLeave;

use App\Http\Controllers\Controller;
use App\Model\MpLeaveApplication;
use App\Traits\ProfileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;


class HolidayApprovalController extends Controller
{
    use ProfileTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (authInfo()->usertype == 'speaker') {
            $where1 = ["status" => 1];
            $where2 = ["status" => 2];
            $where3 = ["status" => 3];
            $data['allLeaves'] = MpLeaveApplication::with(['profileInfo'])->where($where1)->get();
            $data['allapproveLeaves'] = MpLeaveApplication::with(['profileInfo'])->where($where2)->get();
            $data['all_reject_leave'] = MpLeaveApplication::with(['profileInfo'])->where($where3)->get();
            if (isApi()) {
                $response['status'] = 'success'; // return data
                $response['message'] = ''; // return data
                $response['api_info'] = $data; // return data
                return response()->json($response);
            }
            return view('backend.profileActivities.leaveApproval.index', $data);
        } else {
            return redirect()->back()->with('error', Lang::get("Leave Approval Menu Hon'ble Speaker Only!!!"));
        }

    }

    public function approveLeave()
    {
        $where = ["status" => 2];
        if (authInfo()->usertype == 'speaker') {
            $data['allapproveLeaves'] = MpLeaveApplication::with(['profileInfo'])->where($where)->get();
            //dd($data['allLeaves']);
            if (isApi()) {
                $response['status'] = 'success'; // return data
                $response['message'] = ''; // return data
                $response['api_info'] = $data; // return data
                return response()->json($response);
            }

            return view('backend.profileActivities.leaveApproval.index', $data);
        } else {
            return redirect(route('dashboard'));
        }

    }


    public function approvalSubmit(Request $request)
    {
        try {
            $update_data = [
                "status" => $request->status,
                "remarks" => $request->remarks,
                "decide_by" => authInfo()->id,
                "decide_at" => date('Y-m-d')
            ];

            MpLeaveApplication::whereId($request->id)->update($update_data);
            $response['status'] = 'success';
            $response['message'] = 'Success';
            $response['reload_url'] = '';
        } catch (\Exception $e) {
            $response['failed'] = 'Failed';
            $response['message'] = $e;
            $response['reload_url'] = '';
        }
        return response()->json($response);
    }

    public function show($id)
    {
        $data['showData'] = MpLeaveApplication::find($id);
        if (isApi()) {
            $response['status'] = 'success'; // return data
            $response['message'] = ''; // return data
            $response['api_info'] = $data; // return data
            return response()->json($response);
        }
        return view('backend.profileActivities.mp-leave.leave-application.reject_show', $data);
    }


    public function showRejectData($id)
    {
        $data['showData'] = MpLeaveApplication::find($id);
        if (isApi()) {
            $response['status'] = 'success'; // return data
            $response['message'] = ''; // return data
            $response['api_info'] = $data; // return data
            return response()->json($response);
        }
        return view('backend.profileActivities.leaveApproval.reject-show', $data);
    }

    public function showApproveData($id){
        $data['showData'] = MpLeaveApplication::find($id);
        return view('backend.profileActivities.leaveApproval.approved-show', $data);
    }


    public function create(){
        //
    }


    public function store(Request $request){
        //
    }


    public function edit($id){}


    public function update(Request $request, $id){
        //
    }

    public function destroy($id){
        //
    }
}
