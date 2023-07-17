<?php

namespace App\Http\Controllers\Backend\MasterSetup;

use App\Model\Profile;
use App\Model\Ministry;
use App\Model\Parliament;
use App\Model\Mpattendance;
use App\Model\CommitteeRoom;
use App\Model\SongshodBlock;
use App\Model\SongshodFloor;
use Illuminate\Http\Request;
use App\Model\CommitteeMeeting;
use App\Model\ParliamentSession;
use Illuminate\Support\Facades\DB;
use App\Model\CommitteeDesignation;
use App\Model\NewStandingCommittee;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class CommitteeMeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo "index";
        $data['committeeMeeting']=CommitteeMeeting::leftJoin('new_standing_committees','new_standing_committees.id','=','committee_meetings.new_standing_committees_id')
        ->leftJoin('committee_rooms', 'committee_rooms.id', '=', 'committee_meetings.committee_rooms_id')
            ->select('committee_meetings.*','new_standing_committees.committee_name', 'committee_rooms.name_bn as room_name_bn', 'committee_rooms.name_en as room_name_en')
            ->get();
//    dd($data['committeeMeeting']);         
        if (isApi()) {
        $response['status'] = 'success';
        $response['message'] = '';
        $response['api_info']    = $data;
        return response()->json($response);        }
        return view('backend.master_setup.committee_meeting.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        echo "create";
                // echo "create";
                $data['profiles'] = Profile::all();
                // dd($data['profiles']);
                $data['committee_designations'] = CommitteeDesignation::all();
                $data['parliaments'] = Parliament::where('status', 1)->first();
                $data['ministries'] = Ministry::orderBy('id', 'asc')->get();
                $data['newStandingCommittee'] = NewStandingCommittee::orderBy('id', 'asc')->get();
                $data['committeeRoom'] = CommitteeRoom::orderBy('id', 'asc')->get();
                $data['current_parliament_session']  = getCurrentSession();
                if (isApi()) {
                    $response['status'] = 'success';
                    $response['message'] = '';
                    $response['api_info']    = $data;
                    return response()->json($response);
                }
                return view('backend.master_setup.committee_meeting.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // $validator = Validator::make($request->all(), [        
        //     'new_standing_committees_id' => 'required',
        //     'committee_rooms_id' => 'required',
        //     'date_meeting' => 'required',
        //     'time_starting' => 'required'            
        // ]);

        try{

        $data = new CommitteeMeeting();
        $data->new_standing_committees_id=$request->new_standing_committees_id;
        $data->committee_rooms_id=$request->committee_rooms_id;
        $data->status=$request->status;
        $data->date_meeting=date('y-m-d',strtotime($request->date_meeting));
        // dd($data->date_meeting);
        $data->time_starting=$request->time_starting;
        $data->time_ending=$request->time_ending;
        $done = $data->save();
        if($done){
            return response()->json([
                'status'=>'success',
                'message'=>'Successfully created',
                'reload_url'=>route('admin.master_setup.committee_meeting.index'),
            ]);
            // return redirect()->route('admin.master_setup.committee_meeting.index')->with('success','Data Saved successfully');
        }else{
            return redirect()->route('admin.master_setup.committee_meeting.create')->with('error','Data does not save successfully')->withInput();
        }
    } catch (\Exception $e) {
        $errorMessage=$e->getMessage();
        $customMessage="Exception! Something went wrong please try again!";

        \Session::flash('error', $customMessage, true);
        return redirect()->back()->withInput(); //If you want to go back    
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
        echo "this is show method from CommitteeMeetingController";

        $to_date = '2021-08-01';
        $meetingList = DB::table('committee_meetings')
        ->whereDate('date_meeting',$to_date)
        ->first();

        $final_result =  (!empty($meetingList))? json_encode(array(
                                        'id'=> $meetingList->id,
                                        'standing_committees_id'=> $meetingList->new_standing_committees_id,
                                        'committee_rooms_id'=>$meetingList->committee_rooms_id,
                                        'status'=>$meetingList->status,
                                        'date_meeting'=>$meetingList->date_meeting,
                                        'time_starting'=>$meetingList->time_starting,
                                        'time_ending'=>$meetingList->time_ending,
                                        'created_at'=>$meetingList->created_at                                    
                                    ),true):[];
    
        return  $final_result; 
    }

    public function getMeetingList($from_date,$to_date = null){
        $final_result = "";
        if ($to_date) {
            $meetingList = DB::table('committee_meetings')
                                ->whereDateBetween('date_meeting', [$from_date, $to_date])
                                ->get();
        }else{
            $meetingList = DB::table('committee_meetings')
                                ->whereDate('date_meeting',$from_date)
                                ->get();
            
        }
        $final_result =  (!empty($meetingList))? json_encode(array('standing_committees_id'=> $meetingList->new_standing_committees_id,'committee_rooms_id'=>$meetingList->committee_rooms_id),true):[];

        return  $final_result; 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['committeeMeeting'] = CommitteeMeeting::find($id);
        $data['newStandingCommittee'] = NewStandingCommittee::all();
        $data['committeeRoom'] = CommitteeRoom::all();
        $data['songshodBlock'] = SongshodBlock::all();
        $data['songshodFloor'] = SongshodFloor::all();
        $data['current_parliament_session']  = getCurrentSession();

        return view('backend.master_setup.committee_meeting.edit', $data);
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
        $data = new CommitteeMeeting();
        try {
            $validator = Validator::make($request->all(), [                      
                'new_standing_committees_id' => 'required',
                'committee_rooms_id' => 'required',
                'date_meeting' => 'required',
                'time_starting' => 'required'
            ]);
            if ($validator->fails()) {
                if (isApi()) {
                    $response['validation'] = $validator;
                    return response()->json($response);
                }
                return response()->json($validator);
            }
            $data = CommitteeMeeting::find($id);
            $data->new_standing_committees_id=$request->new_standing_committees_id;
            $data->committee_rooms_id=$request->committee_rooms_id;
            $data->status=$request->status;
            $data->date_meeting=date('y-m-d',strtotime($request->date_meeting));
            $data->time_starting=$request->time_starting;
            $data->time_ending=$request->time_ending;
            $result = $data->update();
            if ($result) {
                return response()->json([
                    'status'=>'success',
                    'message'=>'Successfully created',
                    'reload_url'=>route('admin.master_setup.committee_meeting.index'),
                ]);
                // return redirect()->route('admin.master_setup.committee_meeting.index')->with('success', 'Data update successfully');
            } else {
                return redirect()->route('admin.master_setup.committee_meeting.edit')->with('error', 'Data does not update successfully')->withInput();
            }
        } catch (\Exception $e) {

            $errorMessage = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            \Session::flash('error', $errorMessage, true);
            return redirect()->back()->withInput(); //If you want to go back

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
            $fileCat = CommitteeMeeting::find($id);
            $fileCat->delete();
            return response()->json(["status"=>"success"]);

        } catch (\Exception $e) {

            $errorMessage=$e->getMessage();
            $customMessage="Exception! Something went wrong please try again!";

            \Session::flash('error', $customMessage, true);
            return response()->json(['status'=>'error']);
        }
    }
    public function listAttendance(Request $request)
    {
        $selected_date = explode("~", $request->date);
        $start = date('Y-m-d', strtotime($selected_date[0]));
        $end = date('Y-m-d', strtotime($selected_date[1]));
        $record_list = DB::table('committee_meetings')
                            ->leftjoin('new_standing_committees','new_standing_committees.id','=','committee_meetings.new_standing_committees_id')
                            ->whereBetween('date_meeting',[$start,$end])
                            ->select('committee_meetings.*','new_standing_committees.committee_name')
                            ->get();
        $final_result = ' <table id="list_orders_table" class="table table-sm table-bordered table-striped"> <thead> <tr> <th>' . \Lang::get("Date") . '</th><th>' . \Lang::get("Committee Name") . '</th> <th>' . \Lang::get("Starting Time") . '</th><th>' . \Lang::get("Ending Time") . '</th><th>' . \Lang::get("Status") . '</th></tr></thead><tbody>';
        if (count($record_list) > 0) {
            foreach ($record_list as $r) {
                $r->status = ($r->status == 1) ? \Lang::get('Active') : \Lang::get('Inactive');
                $final_result .= '<tr><td>'.digitDateLang(nanoDateFormat($r->date_meeting)).'</td><td>'.$r->committee_name.'</td><td>'.digitDateLang($r->time_starting).'</td><td>'.digitDateLang($r->time_ending).'</td><td>'.$r->status.'</td></tr>';
            }
            $final_result .= '</tbody></table>';
            return json_encode(array('status' => true, 'data' => $final_result), true);
        } else {
            return json_encode(array('status' => false, 'data' => $final_result), true);
        }        
    }

}
