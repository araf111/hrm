<?php

namespace App\Http\Controllers\Backend\MasterSetup;

use App\Model\Profile;
use App\Model\Ministry;
use App\Model\Parliament;
use App\Model\SongshodRoom;
use App\Model\CommitteeRoom;
use App\Model\SongshodBlock;
use App\Model\SongshodFloor;
use Illuminate\Http\Request;
use App\Model\CommitteeMeeting;
use App\Model\CommitteeDesignation;
use App\Model\NewStandingCommittee;
use App\Http\Controllers\Controller;
use App\Model\OfficeWiseTelephonePabx;
use Illuminate\Support\Facades\Validator;

class CommitteeRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data['committees'] = NewStandingCommittee::whereNull('deleted_by')
        // ->leftJoin('parliaments','parliaments.id','=','new_standing_committees.parliaments_id')
        // ->leftJoin('ministries','ministries.id','=','new_standing_committees.ministries_id')
        // ->select('new_standing_committees.*','ministries.name_bn as ministry_name','parliaments.parliament_number as parliament_number')
        // ->get();
        // if (isApi()) {
        // $response['status'] = 'success';
        // $response['message'] = '';
        // $response['api_info']    = $data;
        // return response()->json($response);
        // }
        $data['committeeRoom'] = CommitteeRoom::all();
        $data['songshodBlock'] = SongshodBlock::orderBy('id', 'asc')->get();
        $data['songshodFloor'] = SongshodFloor::orderBy('id', 'asc')->get();
        $data['songshodRoom'] = SongshodRoom::orderBy('id', 'asc')->get();
        $data['phone_pabx'] = OfficeWiseTelephonePabx::all();  
        
        return view('backend.master_setup.committee_room.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        echo "create";
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
        return view('backend.master_setup.committee_room.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $existingSongshodRoom = SongshodRoom::where('block_id', $request->songshod_blocks_id)
            ->where('floor_id', $request->songshod_floors_id)
            ->first();

        if(!empty($existingSongshodRoom)){
            return redirect()->route('admin.master_setup.committee_room.create')->with('error','Room Already Booked');
        }

        $rules = [
            'name_bn'        => 'required',
            'name_en'        => 'required',
            'house_buildings_id'      => 'required',
            'songshod_blocks_id'      => 'required',
            'songshod_floors_id'      => 'required',
            'songshod_rooms_id'      => 'required',
        ];
        $message = [
            'name_bn.required'      => 'The name field is required.',
            'name_en.required'        => 'The name field is required',
            'house_buildings_id.required'        => 'The building field is required.',
            'songshod_blocks_id.required'        => 'The block field is required.',
            'songshod_floors_id.required'        => 'The floor field is required.',
            'songshod_rooms_id.required'        => 'The room field is required.',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
              
        try{
            $data = new CommitteeRoom();
            $data->name_bn= $request->name_bn; 
            $data->name_en= $request->name_en; 
            $data->house_buildings_id= 1; 
            $data->songshod_blocks_id= $request->songshod_blocks_id; 
            $data->songshod_floors_id= $request->songshod_floors_id; 
            $data->songshod_rooms_id= $request->songshod_rooms_id; 
            // $data->telephone= $request->telephone; 
            // $data->pabx= $request->pabx; 
            $data->status= $request->status; 
            $done = $data->save();
            if($done){
                return redirect()->route('admin.master_setup.committee_room.index')->with('success','Data Saved successfully');
            }else{
                return redirect()->route('admin.master_setup.committee_room.create')->with('error','Data does not save successfully')->withInput();
            }
        } catch (\Exception $e) {
            $errorMessage=$e->getMessage();
            $customMessage="Exception! Something went wrong please try again!";

            \Session::flash('error', $customMessage, true);
            return redirect()->back()->withInput(); //If you want to go back    
        }
    }

    public function getItems($type,$block,$floor=null,$room = null){
        $final_result = "";
        if ($type == 'floor') {
            // $floor_list = SongshodFloor::where('block_id',$block)->get();
            $floor_list = SongshodFloor::orderBy('id', 'ASC')->get();
            $final_result .= "<option value=''>" . \Lang::get('Select Floor') . "</option>";
            if(!empty($floor_list)){
                foreach($floor_list as $l){
                    if(session()->get('language') == 'bn'){
                        $final_result .= "<option value='$l->id'>" .$l->name_bn. "</option>";
                    }else{
                        $final_result .= "<option value='$l->id'>" .$l->name. "</option>";
                    }
                }
            }
        }elseif ($type == 'room') {
            $room_list = SongshodRoom::where('block_id',$block)->where('floor_id',$floor)->get();
            $final_result .= "<option value=''>" . \Lang::get('Select Room Number') . "</option>";
            if(!empty($room_list)){
                foreach($room_list as $l){
                    $final_result .= "<option value='$l->id'>" .digitDateLang($l->room) . "</option>";
                }
            }
        }elseif ($type == 'phonepabx') {
            $phone_pabx = OfficeWiseTelephonePabx::where('block_id',$block)
                ->where('floor_id',$floor)
                ->where('room_id',$floor)
                ->first();  
            $final_result =  (!empty($phone_pabx))? json_encode(array('phone'=> $phone_pabx->num_of_telephone,'pabx'=>$phone_pabx->num_of_pabx),true):[];
        }
        return  $final_result; 
    }
        
    
    // }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo "show";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['committeeRoom'] = CommitteeRoom::find($id);
        // dd($data['committeeRoom']);
        $data['songshodBlock'] = SongshodBlock::all();
        $data['songshodFloor'] = SongshodFloor::all();
        $data['songshodRoom'] = SongshodRoom::where('block_id', $data['committeeRoom']->songshod_blocks_id)
            ->where('floor_id', $data['committeeRoom']->songshod_floors_id )
            ->get();
        // dd($data['songshodRoom']);
        return view('backend.master_setup.committee_room.edit', $data);
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
        $roomData = CommitteeRoom::find($id);

        if($roomData->songshod_rooms_id != $request->songshod_rooms_id){
            $existingSongshodRoom = CommitteeRoom::where('songshod_rooms_id', $request->songshod_rooms_id)
            ->first();

            if(!empty($existingSongshodRoom)){
                return redirect()->route('admin.master_setup.committee_room.edit', $id)->with('error','Room Already Booked');
            }
        }
        
        $rules = [
            'name_bn'        => 'required',
            'name_en'        => 'required',
            'house_buildings_id'      => 'required',
            'songshod_blocks_id'      => 'required',
            'songshod_floors_id'      => 'required',
            'songshod_rooms_id'      => 'required',
        ];
        $message = [
            'name_bn.required'      => 'The name field is required.',
            'name_en.required'        => 'The name field is required',
            'house_buildings_id.required'        => 'The building field is required.',
            'songshod_blocks_id.required'        => 'The block field is required.',
            'songshod_floors_id.required'        => 'The floor field is required.',
            'songshod_rooms_id.required'        => 'The room field is required.',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        try {
            $data = CommitteeRoom::find($id);
            $data->name_bn= $request->name_bn; 
            $data->name_en= $request->name_en; 
            $data->house_buildings_id= 1; 
            $data->songshod_blocks_id= $request->songshod_blocks_id; 
            $data->songshod_floors_id= $request->songshod_floors_id; 
            $data->songshod_rooms_id= $request->songshod_rooms_id; 
            // $data->telephone= $request->telephone; 
            // $data->pabx= $request->pabx; 
            $data->status= $request->status;
            $result = $data->update();

            if ($result) {
                return redirect()->route('admin.master_setup.committee_room.index')->with('success', 'Data update successfully');
            } else {
                return redirect()->route('admin.master_setup.committee_room.edit')->with('error', 'Data does not update successfully')->withInput();
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
            $existingId = CommitteeMeeting::where('committee_rooms_id',$id)->first();
            if (isset($existingId->committee_rooms_id) && $existingId->designation_id > 0) {
                return response()->json(["status"=>"warning"]);
            }else{
                $fileCat = CommitteeRoom::find($id);
                $fileCat->delete();
                return response()->json(["status"=>"success"]);
            }  
            } catch (\Exception $e) {
                $errorMessage=$e->getMessage();
                $customMessage="Exception! Something went wrong please try again!";
                \Session::flash('error', $customMessage, true);
                return response()->json(['status'=>'error']);
            }
   

    }
}
