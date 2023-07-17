<?php

namespace App\Http\Controllers\Backend\MasterSetup;

use PDF;
use App\User;
use App\Model\Profile;
use App\Model\Ministry;
use App\Model\Department;
use App\Model\Parliament;
use App\Model\Constituency;
use App\Model\MpOfficeRoom;
use App\Model\SongshodRoom;
use App\Model\SongshodBlock;
use App\Model\SongshodFloor;
use Illuminate\Http\Request;
use App\Model\ParliamentRule;
use App\Model\PoliticalParty;
use App\Model\ParliamentSession;
use Illuminate\Support\Facades\DB;
use App\Model\CommitteeDesignation;
use App\Model\NewStandingCommittee;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use App\Model\OfficeWiseTelephonePabx;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class MpOfficeRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $data['mpOfficeRooms'] = MpOfficeRoom::leftJoin('users', 'users.id', '=', 'mp_office_rooms.mp_id')
            ->leftJoin('constituencies', 'constituencies.id', '=', 'mp_office_rooms.constituencies_id')
            ->select('mp_office_rooms.*', 'users.name_bn as mp_name_bn', 'users.name as mp_name_en', 'constituencies.bn_name as consticuency_name_bn', 'constituencies.name as consticuency_name_en')
            ->get();
        return view('backend.master_setup.mp_office_room.index', $data);
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
        $data['parliamentSession']  = ParliamentSession::where('status', 1)->orderBy('id', 'desc')->get();
        $data['profiles'] = Profile::all();
        $data['only_booked_room_list'] = MpOfficeRoom::select('room_ids')->get()->pluck('room_ids');
        $data['booked_room_list'] = json_encode(MpOfficeRoom::select('room_ids')->get());
        $test = [];
        $hello = "";
        for ($x = 0; $x < count($data['only_booked_room_list']); $x++) {
            $hello .= $data['only_booked_room_list'][$x];
            if ($x < count($data['only_booked_room_list']) - 1) {
                $hello .= ',';
            }
        }
        $test = array_unique(explode(',', $hello));
        $data['booked_ids'] = $test;
        //dd($test);
        //  dd($data['booked_room_list']);
        //  $only_room_booked_list = json_encode($data['booked_room_list']);
        //  $room_booked_list = json_encode( $data['only_booked_room_list']);
        //  dd($room_booked_list);
        //  dd($only_room_booked_list);
        // dd($data['profiles']);
        $data['committee_designations'] = CommitteeDesignation::all();
        $data['parliaments'] = Parliament::where('status', 1)->first();
        $data['ministries'] = Ministry::orderBy('id', 'asc')->get();
        $data['profiles'] = Profile::all();
        // dd($data['profiles']);
        $data['committee_designations'] = CommitteeDesignation::all();
        $data['parliaments'] = Parliament::where('status', 1)->first();
        $data['ministries'] = Ministry::orderBy('id', 'asc')->get();
        $data['songshodBlock'] = SongshodBlock::orderBy('id', 'asc')->get();
        $data['songshodFloor'] = SongshodFloor::orderBy('id', 'asc')->get();
        $data['songshodRoom'] = SongshodRoom::orderBy('id', 'asc')->get();
        // dd($data['songshodRoom']);
        $data['OfficeWiseTelephonePabx'] = OfficeWiseTelephonePabx::orderBy('id', 'asc')->get();
        return view('backend.master_setup.mp_office_room.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $profile = Profile::where('user_id', $request->user_id)->first();
        $constituency_id = $profile->constituency_id;

        try {
            $validator = Validator::make($request->all(), [
                'songshod_rooms_id[]' => 'required',
                'user_id' => 'required'
            ]);
            $mpOfficeRoom = new MpOfficeRoom();
            $mpOfficeRoom->parliament_sessions_id = $request->parliament_session_id;
            $mpOfficeRoom->mp_id = $request->user_id;
            $mpOfficeRoom->political_parties_id = 1;
            $mpOfficeRoom->constituencies_id = $constituency_id;
            $mpOfficeRoom->songshod_blocks_id = $request->songshod_blocks_id;
            $mpOfficeRoom->songshod_floors_id = $request->songshod_floors_id;
            $mpOfficeRoom->room_ids = implode(',', $request->songshod_rooms_id);
            $mpOfficeRoom->status = $request->status;
            $mpOfficeRoom->allocation_date = date('y-m-d', strtotime($request->allocation_date));
            $mpOfficeRoom->disallocation_date = date('y-m-d', strtotime($request->disallocation_date));
            // $mpOfficeRoom->disallocation_date = now();
            $mpOfficeRoom->created_by = authInfo()->id;
            $result = $mpOfficeRoom->save();
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully updated',
                    'reload_url' => route('admin.master_setup.mp_office_room.index'),
                ]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Not Successfully updated']);
            }
        } catch (\Throwable $th) {
            $errorMessage = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";
            \Session::flash('error', $customMessage, true);
            return redirect()->back()->withInput(); //If you want to go back 
        }
    }
    public function Search_form()
    {
        $data['mpOfficeRooms'] = MpOfficeRoom::leftJoin('users', 'users.id', '=', 'mp_office_rooms.mp_id')
            ->leftJoin('constituencies', 'constituencies.id', '=', 'mp_office_rooms.constituencies_id')
            ->select('mp_office_rooms.*', 'users.name_bn as mp_name_bn', 'users.name as mp_name_en', 'constituencies.bn_name as consticuency_name_bn', 'constituencies.name as consticuency_name_en')
            ->get();
        $data['songshodBlock'] = SongshodBlock::all();
        // $data['user'] = User::where('id','!=',1)->get();
        $data['profiles'] = Profile::get();
        $data['politicalParties'] = PoliticalParty::get();
        $data['parliamentSession']  = ParliamentSession::where('status', 1)->orderBy('id', 'desc')->get();



        // dd($data['user']);
        // dd($data['songshodBlock']);
        return view('backend.master_setup.mp_office_room.search', $data);
    }
    public function mpOfficeRoomSearch(Request $request)
    {
        $type = (isset($request->type)) ? $request->type : '';


        // $final_result = '<p class="text-center"><a class="btn btn-sm btn-success" onClick="load_report(\'pdf\')"> <i class="fa fa-list"></i> PDF Report </a> &nbsp;<a class="btn btn-sm btn-success" onClick="load_report(\'xlsx\')"> <i class="fa fa-list"></i> Excel Report </a> &nbsp;<a class="btn btn-sm btn-info" onClick="exportDoc()"> <i class="fa fa-list"></i> Doc Report </a></p>';       
        // $final_result = '<div class="row"> <select class="form-control btn btn-primary" style="width: 15%" name="reportTypeSelcetion" id="reportTypeSelcetion"><option onchange="exportDoc()" value="doc">Doc Report</option><option onchange="load_report(\'pdf\')" value="pdf">PDF Report</option><option onchange="exportExcel()" value="xlsx">Excel Report</option> </select></div>';
        // $final_result = '<div class="row"> <select class="form-control btn btn-primary" style="width: 15%" name="reportTypeSelcetion" id="reportTypeSelcetion"><option value="doc">Doc Report</option><option value="pdf">PDF Report</option><option value="xlsx">Excel Report</option> </select></div>';


        $final_result = ' <table id="list_orders_table" class="table table-sm table-bordered table-striped"> <thead> <tr> <th>' . \Lang::get("Constituency Area No") . '</th><th>' . \Lang::get("Photo") . '</th> <th>' . \Lang::get("MP Name") . '</th><th>' . \Lang::get("Constituency Area Name") . '</th><th>' . \Lang::get("Block, Level & Room No") . '</th><th>' . \Lang::get("Status") . '</th></tr></thead><tbody>';

        if ($type == 'mp') {
            $mp_id = (isset($request->mp_id) && $request->mp_id > 0) ? $request->mp_id : 0;
            // $room_record = MpOfficeRoom::where('id',$mp_id)->first();
            $mpOfficeRooms = MpOfficeRoom::where('mp_id', $mp_id)
                ->leftJoin('users', 'users.id', '=', 'mp_office_rooms.mp_id')
                ->leftJoin('constituencies', 'constituencies.id', '=', 'mp_office_rooms.constituencies_id')
                ->select('mp_office_rooms.*', 'users.name_bn as mp_name_bn', 'users.name as mp_name_en', 'constituencies.bn_name as consticuency_name_bn', 'constituencies.name as consticuency_name_en')
                ->get();
            // dd($mpOfficeRooms);
            if (count($mpOfficeRooms) > 0) {
                foreach ($mpOfficeRooms as $r) {
                    $r->status = ($r->status == 1) ? \Lang::get('Active') : \Lang::get('Inactive');
                    $final_result .= '<tr><td>' . $r->constituencies_id . '</td><td>' . $r->constituencies_id . '</td><td>' . $r->mp_name_bn . '</td><td>' . $r->consticuency_name_bn . '</td><td>' . \Lang::get("Block") . $r->songshod_blocks_id . \Lang::get("Floor") . $r->songshod_floors_id . \Lang::get("Room") . $r->room_ids . '</td><td>' . $r->status . '</td></tr>';
                }
                $final_result .= '</tbody></table>';
                $final_result .= '<p class="text-center"><a class="btn btn-sm btn-success" onClick="load_report(\'pdf\')"> <i class="fa fa-list"></i> PDF Report </a> &nbsp;<a class="btn btn-sm btn-success" onClick="tableToExcel()"> <i class="fa fa-list"></i> Excel Report </a> &nbsp;<a class="btn btn-sm btn-info" onClick="exportDoc()"> <i class="fa fa-list"></i> Doc Report </a></p>';
                return json_encode(array('status' => true, 'data' => $final_result), true);
            } else {
                return json_encode(array('status' => false, 'data' => $final_result), true);
            }
        } else if ($type == 'room') {
            $block = (isset($request->block_id)) ? $request->block_id : 0;
            $floor = (isset($request->floor_id)) ? $request->floor_id : 0;
            if ($floor > 0) {
                $mpOfficeRooms = MpOfficeRoom::where('songshod_blocks_id', $block)
                    ->where('songshod_floors_id', $floor)
                    ->leftJoin('users', 'users.id', '=', 'mp_office_rooms.mp_id')
                    ->leftJoin('constituencies', 'constituencies.id', '=', 'mp_office_rooms.constituencies_id')
                    ->select('mp_office_rooms.*', 'users.name_bn as mp_name_bn', 'users.name as mp_name_en', 'constituencies.bn_name as consticuency_name_bn', 'constituencies.name as consticuency_name_en')
                    ->get();
            } else {
                $mpOfficeRooms = MpOfficeRoom::where('songshod_blocks_id', $block)
                    ->leftJoin('users', 'users.id', '=', 'mp_office_rooms.mp_id')
                    ->leftJoin('constituencies', 'constituencies.id', '=', 'mp_office_rooms.constituencies_id')
                    ->select('mp_office_rooms.*', 'users.name_bn as mp_name_bn', 'users.name as mp_name_en', 'constituencies.bn_name as consticuency_name_bn', 'constituencies.name as consticuency_name_en')
                    ->get();
            }

            // dd($mpOfficeRooms);
            if (count($mpOfficeRooms) > 0) {
                foreach ($mpOfficeRooms as $r) {
                    $r->status = ($r->status == 1) ? \Lang::get('Active') : \Lang::get('Inactive');
                    $final_result .= '<tr><td>' . $r->constituencies_id . '</td><td>' . $r->constituencies_id . '</td><td>' . $r->mp_name_bn . '</td><td>' . $r->consticuency_name_bn . '</td><td>' . \Lang::get("Block") . $r->songshod_blocks_id . \Lang::get("Floor") . $r->songshod_floors_id . \Lang::get("Room") . $r->room_ids . '</td><td>' . $r->status . '</td></tr>';
                }
                $final_result .= '</tbody></table>';
                $final_result .= '<p class="text-center"><a class="btn btn-sm btn-success" onClick="load_report(\'pdf\')"> <i class="fa fa-list"></i> PDF Report </a> &nbsp;<a class="btn btn-sm btn-success" onClick="tableToExcel()"> <i class="fa fa-list"></i> Excel Report </a> &nbsp;<a class="btn btn-sm btn-info" onClick="exportDoc()"> <i class="fa fa-list"></i> Doc Report </a></p>';
                return json_encode(array('status' => true, 'data' => $final_result), true);
            } else {
                return json_encode(array('status' => false, 'data' => $final_result), true);
            }
        } else if ($type == 'session') {
            $parliament_session_id = (isset($request->parliament_session_id)) ? $request->parliament_session_id : 0;
            $political_parties_id = (isset($request->political_parties_id)) ? $request->political_parties_id : 0;
            if ($political_parties_id > 0) {
                // dd($mpOrBlock,$floor);
                $mpOfficeRooms = MpOfficeRoom::where('parliament_sessions_id', $parliament_session_id)
                    ->where('political_parties_id', $political_parties_id)
                    ->leftJoin('users', 'users.id', '=', 'mp_office_rooms.mp_id')
                    ->leftJoin('constituencies', 'constituencies.id', '=', 'mp_office_rooms.constituencies_id')
                    ->select('mp_office_rooms.*', 'users.name_bn as mp_name_bn', 'users.name as mp_name_en', 'constituencies.bn_name as consticuency_name_bn', 'constituencies.name as consticuency_name_en')
                    ->get();
                // dd($mpOfficeRooms);
                if (count($mpOfficeRooms) > 0) {
                    foreach ($mpOfficeRooms as $r) {
                        $r->status = ($r->status == 1) ? \Lang::get('Active') : \Lang::get('Inactive');
                        $final_result .= '<tr><td>' . $r->constituencies_id . '</td><td>' . $r->constituencies_id . '</td><td>' . $r->mp_name_bn . '</td><td>' . $r->consticuency_name_bn . '</td><td>' . \Lang::get("Block") . $r->songshod_blocks_id . \Lang::get("Floor") . $r->songshod_floors_id . \Lang::get("Room") . $r->room_ids . '</td><td>' . $r->status . '</td></tr>';
                    }
                    $final_result .= '</tbody></table>';
                    $final_result .= '<p class="text-center"><a class="btn btn-sm btn-success" onClick="load_report(\'pdf\')"> <i class="fa fa-list"></i> PDF Report </a> &nbsp;<a class="btn btn-sm btn-success" onClick="tableToExcel()"> <i class="fa fa-list"></i> Excel Report </a> &nbsp;<a class="btn btn-sm btn-info" onClick="exportDoc()"> <i class="fa fa-list"></i> Doc Report </a></p>';
                    return json_encode(array('status' => true, 'data' => $final_result), true);
                } else {
                    return json_encode(array('status' => false, 'data' => $final_result), true);
                }
            } else {
                // echo "sesssion is ".$mpOrBlock;
                $mpOfficeRooms = MpOfficeRoom::where('parliament_sessions_id', $parliament_session_id)
                    ->leftJoin('users', 'users.id', '=', 'mp_office_rooms.mp_id')
                    ->leftJoin('constituencies', 'constituencies.id', '=', 'mp_office_rooms.constituencies_id')
                    ->select('mp_office_rooms.*', 'users.name_bn as mp_name_bn', 'users.name as mp_name_en', 'constituencies.bn_name as consticuency_name_bn', 'constituencies.name as consticuency_name_en')
                    ->get();
                // dd($mpOfficeRooms);
                if (count($mpOfficeRooms) > 0) {
                    foreach ($mpOfficeRooms as $r) {
                        $r->status = ($r->status == 1) ? \Lang::get('Active') : \Lang::get('Inactive');
                        $final_result .= '<tr><td>' . $r->constituencies_id . '</td><td>' . $r->constituencies_id . '</td><td>' . $r->mp_name_bn . '</td><td>' . $r->consticuency_name_bn . '</td><td>' . \Lang::get("Block") . $r->songshod_blocks_id . \Lang::get("Floor") . $r->songshod_floors_id . \Lang::get("Room") . $r->room_ids . '</td><td>' . $r->status . '</td></tr>';
                    }
                    $final_result .= '</tbody></table>';
                    $final_result .= '<p class="text-center"><a class="btn btn-sm btn-success" onClick="load_report(\'pdf\')"> <i class="fa fa-list"></i> PDF Report </a> &nbsp;<a class="btn btn-sm btn-success" onClick="tableToExcel()"> <i class="fa fa-list"></i> Excel Report </a> &nbsp;<a class="btn btn-sm btn-info" onClick="exportDoc()"> <i class="fa fa-list"></i> Doc Report </a></p>';
                    return json_encode(array('status' => true, 'data' => $final_result), true);
                }
            }
            return json_encode(array('status' => false, 'data' => $final_result), true);
        } else {
            return json_encode(array('status' => false, 'data' => $final_result), true);
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
        $data['mpOfficeRoom'] = MpOfficeRoom::where('mp_office_rooms.id', $id)
            ->leftJoin('users', 'users.id', '=', 'mp_office_rooms.mp_id')
            ->leftJoin('constituencies', 'constituencies.id', '=', 'mp_office_rooms.constituencies_id')
            ->select('mp_office_rooms.*', 'users.name_bn as mp_name_bn', 'users.name as mp_name_en', 'constituencies.bn_name as consticuency_name_bn', 'constituencies.name as consticuency_name_en')
            ->first();
        return view('backend.master_setup.mp_office_room.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data['mpOfficeRoom'] = MpOfficeRoom::find($id);
        $data['parliamentSession']  = ParliamentSession::where('status', 1)->orderBy('id', 'desc')->get();
        $data['mp_rooms_array'] = (isset($data['mpOfficeRoom']->room_ids) && $data['mpOfficeRoom']->room_ids != '') ? explode(',', $data['mpOfficeRoom']->room_ids) : [];
        $data['profiles'] = Profile::all();
        $data['SongshodBlock'] = SongshodBlock::all();
        $data['SongshodFloor'] = SongshodFloor::all();
        $data['songshodRoom'] = SongshodRoom::all();
        $data['committee_designations'] = CommitteeDesignation::all();
        $data['parliaments'] = Parliament::where('status', 1)->first();
        $data['ministries'] = Ministry::orderBy('id', 'asc')->get();
        $data['profiles'] = Profile::all();
        $data['committee_designations'] = CommitteeDesignation::all();
        $data['parliaments'] = Parliament::where('status', 1)->first();
        $data['ministries'] = Ministry::orderBy('id', 'asc')->get();
        $data['songshodBlock'] = SongshodBlock::orderBy('id', 'asc')->get();
        $data['songshodFloor'] = SongshodFloor::orderBy('id', 'asc')->get();
        $data['songshodRoom'] = SongshodRoom::orderBy('id', 'asc')->get();
        $data['OfficeWiseTelephonePabx'] = OfficeWiseTelephonePabx::orderBy('id', 'asc')->get();
        return view('backend.master_setup.mp_office_room.edit', $data);
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
        $profile = Profile::where('user_id', $request->user_id)->first();
        $constituency_id = $profile->constituency_id;
        // dd($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'songshod_rooms_id[]' => 'required',
                'user_id' => 'required'
            ]);
            $mpOfficeRoom = MpOfficeRoom::find($id);
            $mpOfficeRoom->parliament_sessions_id = $request->parliament_session_id;
            $mpOfficeRoom->mp_id = $request->user_id;
            $mpOfficeRoom->political_parties_id = 1;
            $mpOfficeRoom->constituencies_id = $constituency_id;
            $mpOfficeRoom->songshod_blocks_id = $request->songshod_blocks_id;
            $mpOfficeRoom->songshod_floors_id = $request->songshod_floors_id;
            $mpOfficeRoom->room_ids = implode(',', $request->songshod_rooms_id);
            $mpOfficeRoom->status = $request->status;
            $mpOfficeRoom->allocation_date = date('y-m-d', strtotime($request->allocation_date));
            $mpOfficeRoom->disallocation_date = date('y-m-d', strtotime($request->disallocation_date));
            $mpOfficeRoom->created_by = authInfo()->id;
            $mpOfficeRoom->updated_by = authInfo()->id;
            // dd($mpOfficeRoom);
            $result = $mpOfficeRoom->save();
            if ($result) {

                $data = array(
                    'parliament_sessions_id' => $request->parliament_session_id,
                    'mp_id' => $request->user_id,
                    'political_parties_id' => 1,
                    'constituencies_id' => $constituency_id,
                    'songshod_blocks_id' => $request->songshod_blocks_id,
                    'songshod_floors_id' => $request->songshod_floors_id,
                    'room_ids' => implode(',', $request->songshod_rooms_id),
                    'status' => $request->status,
                    'allocation_date' => date('y-m-d', strtotime($request->allocation_date)),
                    'disallocation_date' => date('y-m-d', strtotime($request->disallocation_date)),
                    'updated_by' => authInfo()->id
                );
                DB::table('mp_office_room_logs')->insert($data);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully updated',
                    'reload_url' => route('admin.master_setup.mp_office_room.index'),
                ]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Not Successfully updated']);
            }
        } catch (\Throwable $th) {
            $errorMessage = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";
            \Session::flash('error', $customMessage, true);
            return redirect()->back()->withInput(); //If you want to go back 
        }
    }

    public function roomExist($room_id)
    {
        $isExist = MpOfficeRoom::where('room_ids', $room_id)->get();
        // dd($isExist->id > 0);
        // echo $isExist->room_ids;
        // var $result;
        if (count($isExist) > 0) {
            //  return true;
            return response()->json([
                'status' => 'success',
                'message' => 'Room is Blocked'

            ]);
        } else {
            //  return false;
            return response()->json([
                'status' => 'error',
                'message' => 'Room is blanked'

            ]);
        }
        // return $result;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteByRoomID(Request $request)
    {
        $room_id = $request->id;

        try {

            $existing_data = MpOfficeRoom::where('room_ids', $room_id)->first();
            $fileCat = MpOfficeRoom::find($existing_data->id);
            $status = $fileCat->delete();
            if ($status) {
                $fileCat->status = 0;
                $fileCat->deleted_by = authInfo()->id;
                $update = $fileCat->update();
                return response()->json(["status" => "success"]);
            }
        } catch (\Exception $e) {

            $errorMessage = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            \Session::flash('error', $customMessage, true);
            return response()->json(['status' => 'error']);
        }
    }
    public function destroy($id)
    {

        try {
            $fileCat = MpOfficeRoom::find($id);

            $status = $fileCat->delete();
            if ($status) {
                $fileCat->status = 0;
                $fileCat->deleted_by = authInfo()->id;
                $update = $fileCat->update();
                return response()->json(["status" => "success"]);
            }
        } catch (\Exception $e) {

            $errorMessage = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            \Session::flash('error', $customMessage, true);
            return response()->json(['status' => 'error']);
        }
    }
    public function generateReport(Request $request)
    {

        // dd($request->all());
        $doc_type    = $request->doc_type;
        $data['mpOfficeRoom'] = MpOfficeRoom::where('parliament_sessions_id', $request->parliament_session_id)
            ->leftJoin('users', 'users.id', '=', 'mp_office_rooms.mp_id')
            ->leftJoin('constituencies', 'constituencies.id', '=', 'mp_office_rooms.constituencies_id')
            ->select('mp_office_rooms.*', 'users.name_bn as mp_name_bn', 'users.name as mp_name_en', 'constituencies.bn_name as consticuency_name_bn', 'constituencies.name as consticuency_name_en')
            ->get();
        // dd($data['mpOfficeRoom']);
        // dd($doc_type);
        // $type        = $request->report_type; // ammendmend list, acceptance list standing committee list etc.
        $common_header   = \Lang::get("Office Room of Parliament Members");
        // dd($common_header);
        // $final_result .= '<style>.header_section{ line-height:20px; text-align:center;}</style><div style="text-align:center; font-size:18px;"><div class="header_section mb-3">' . $common_header . '</div><div class="header_section mb-3">' . $wing_name . '</div><div class="header_section mb-4" style="margin-bottom:10px;"><u>' . $department_name . '</u></div><div class="header_section mb-3">' . $report_title . '</div><div class="header_section mb-3">' . $report_header . '</div><div class="header_section my-4" style="margin-top:10px;margin-bottom:20px;"><u>' . $list_header . '</u></div></div> <table id="list_table" class="table table-sm table-bordered table-striped"> <thead> <tr><th width="5%">' . \Lang::get("Serial") . '</th><th width="95%">' . \Lang::get("Subject") . '</th> </tr></thead><tbody>';
        // $record_list = DB::select($query . $where);
        // $final_result .= '<tr><td>' . digitDateLang($sn++) . '</td><td>জনাব ' . $r->from_user_name . '(' . $r->voter_area . '), সদস্য প্রস্তাব করিবেন যে:-<br/>' . digitDateLang(nanoDateFormat($r->created_at)) . ' তারিখের মধ্যে জনমত যাচাইয়ের জন্য বিলটি প্রচার করা হউক।</td></tr>';
        // $final_result .= '</tbody></table>';
        if ($doc_type === 'pdf') {
            $template_name           = 'office_room_list';
            // dd($template_name);
            $pdf_file_name           = 'Test_File_name';
            // dd($pdf_file_name);
            $data['common_header']   = $common_header;
            $data['sample']   = 'This is sample data';
            // dd($data['common_header']);
            // $data['record_list']     = $final_result;
            // $data['wing_name']       = $wing_name;
            // $data['department_name'] = $department_name;
            // $data['report_title']    = $report_title;
            // $data['report_header']   = $report_header;
            // $data['list_header']     = $list_header;
            $pdf                     = PDF::loadView('backend.master_setup.mp_office_room.report.' . $template_name, $data);
            $pdfString               = $pdf->Output('', 'S');
            $pdfBase64               = base64_encode($pdfString);
            return 'data:application/pdf;base64,' . $pdfBase64;
        }
    }
    public function getReport()
    {
        $data['profiles'] = Profile::all();
        $data['booked_room_list'] = MpOfficeRoom::select('room_ids')->get();
        $room_booked_list = json_encode($data['booked_room_list']);
        // dd($booked_list);
    }
}
