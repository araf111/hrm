<?php

namespace App\Http\Controllers\Backend\MasterSetup;

use PDF;
use App\Model\Profile;
// use Barryvdh\DomPDF\PDF;
use App\Model\Ministry;
use App\Model\Parliament;
use App\Model\Constituency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\CommitteeDesignation;
use App\Model\LogStandingCommittee;
use App\Model\NewStandingCommittee;
use App\Http\Controllers\Controller;
use App\Model\StandingCommitteeMember;
use Illuminate\Support\Facades\Validator;

class NewStandingCommitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['committees'] = NewStandingCommittee::whereNull('deleted_by')
        ->leftJoin('parliaments','parliaments.id','=','new_standing_committees.parliaments_id')
        ->leftJoin('ministries','ministries.id','=','new_standing_committees.ministries_id')
        ->select('new_standing_committees.*','ministries.name_bn as ministry_name_bn','ministries.name as ministry_name_en', 'parliaments.parliament_number as parliament_number')
        ->get();

            if (isApi()) {
                $response['status'] = 'success';
                $response['message'] = '';
                $response['api_info']    = $data;
                return response()->json($response);
            }
        return view('backend.master_setup.new_standing_committee.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // echo "create";
        $data['profiles'] = Profile::all();
        // dd($data['profiles']);
        $data['committee_designations'] = CommitteeDesignation::all();
        $data['parliaments'] = Parliament::where('status', 1)->first();
        $data['ministries'] = Ministry::orderBy('id', 'asc')->get();
        if (isApi()) {
            $response['status'] = 'success';
            $response['message'] = '';
            $response['api_info']    = $data;
            return response()->json($response);
        }
        return view('backend.master_setup.new_standing_committee.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [        
            'committee_name' => 'required'            
        ]);

        if ($validator->fails()) {
            if (isApi()) {
                $response['validation'] = $validator;
                return response()->json($response);
            }
            return response()->json($validator);
        } 

        try {
            $newStandingCommittee = new NewStandingCommittee();
            $newStandingCommittee['committee_name'] = $request->committee_name;
            $newStandingCommittee['parliaments_id'] = $request->parliament_id;
            $newStandingCommittee['ministries_id'] = $request->ministry_id;
            $newStandingCommittee['date_from'] = date('y-m-d',strtotime($request->date_from));
            $newStandingCommittee['date_to'] = date('y-m-d',strtotime($request->date_to));
            $newStandingCommittee['status'] = $request->committeeStatus;
            $newStandingCommittee['created_by'] = AuthInfo()->id;
            $newStandingCommittee->save();
            $standing_committee_id = $newStandingCommittee->id;
            $standing_committee_id;
            if($standing_committee_id){
                if(count($request->user_id) > 0){                       
                        foreach ($request->user_id as $i => $value) {
                        $data[] = [
                            'standing_committee_id' => $standing_committee_id,
                            'user_id'      => $request->user_id[$i],
                            'designation_id'  => $request->designation_id[$i],
                            'status'       => $request->status[$i],                           
                            'status_inactive_date' => ($request->status[$i]==0)?now():null,                                                     
                            'created_by'   => authInfo()->id,
                            'created_at'   => now(),
                        ];
                    }
                    $done = DB::table('standing_committee_members')->insert($data);
                }
            }
            if($done){
                return response()->json([
                    'status'=>'success',
                    'message'=>'Successfully created',
                    'reload_url'=>route('admin.master_setup.new_standing_committees.index'),
                ]);
                // return redirect()->route('admin.master_setup.new_standing_committees.index')->with('success','Data Saved successfully');
            }else{
                return redirect()->route('admin.master_setup.new_standing_committees.create')->with('error','Data does not save successfully')->withInput();
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
        // echo "show";
        // echo $id;
        $data['editData'] = NewStandingCommittee::find($id);
        // dd($data['editData']);
        $data['standingCommitteeMembers'] = StandingCommitteeMember::where('standing_committee_id',$id)
        ->leftJoin('profiles','profiles.id','=','standing_committee_members.user_id')
        ->leftJoin('committee_designations','committee_designations.id','=','standing_committee_members.designation_id')
        ->select('standing_committee_members.*','profiles.name_bn as mp_name','committee_designations.name_bn as designation_name')
        ->get();   

    //    dd($data['standingCommitteeMembers']);
        $data['profiles'] = Profile::all();
        $data['parliaments'] = Parliament::where('status', 1)->first();
        // dd($data['parliaments']);
        $data['committee_designations'] = CommitteeDesignation::all();
        // dd($data['committee_designations']);
        $data['constituencies'] = Constituency::all();
        $data['ministries'] = Ministry::orderBy('id', 'asc')->get();
        if (isApi()) {
            $response['status'] = 'success';
            $response['message'] = '';
            $response['api_info']    = $data;
            return response()->json($response);
        }
        return view('backend.master_setup.new_standing_committee.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['editData'] = NewStandingCommittee::find($id);

        if (!empty($data['editData'])) {
            $data['standingCommitteeMembers'] = StandingCommitteeMember::where('standing_committee_id',$id)
            ->leftJoin('profiles','profiles.id','=','standing_committee_members.user_id')
            ->leftJoin('committee_designations','committee_designations.id','=','standing_committee_members.designation_id')
            ->select('standing_committee_members.*','profiles.name_bn as mp_name','committee_designations.name_bn as designation_name')
            ->get();   
            $data['profiles'] = Profile::all();
            $data['parliaments'] = Parliament::where('status', 1)->first();
            $data['committee_designations'] = CommitteeDesignation::all();
            $data['ministries'] = Ministry::orderBy('id', 'asc')->get();
            if (isApi()) {
                $response['status'] = 'success';
                $response['message'] = '';
                $response['api_info']    = $data;
                return response()->json($response);
            }
    
            return view('backend.master_setup.new_standing_committee.edit', $data);
        }else{
           echo "Not Data found";
        }
        
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
       $existing_ids = StandingCommitteeMember::where('standing_committee_id',$id)->get()->pluck('user_id')->toArray(); 
        try {
            $validator = Validator::make($request->all(), [        
                'committee_name' => 'required',
                'date_from' => 'required'
            ]);
            if ($validator->fails()) {
                if (isApi()) {
                    $response['validation'] = $validator;
                    return response()->json($response);
                }
                return response()->json($validator);
            }
            $newStandingCommittee =NewStandingCommittee::find($id);
            $newStandingCommittee->committee_name = $request->committee_name;
            $newStandingCommittee->parliaments_id = $request->parliament_id;
            $newStandingCommittee->ministries_id = $request->ministry_id;
            $newStandingCommittee->date_from = date('Y-m-d',strtotime($request->date_from));
            $newStandingCommittee->date_to = date('Y-m-d',strtotime($request->date_to));
            $newStandingCommittee->status = $request->committeeStatus;
            $newStandingCommittee->updated_by = AuthInfo()->id;
            $updateDone = $newStandingCommittee->update();
            $done = [];
            if($updateDone){                
                if(count($request->user_id) > 0){                       
                    foreach ($request->user_id as $i => $value) { 
                        StandingCommitteeMember::where('standing_committee_id',$id)->whereNotIn('id',$request->standing_committee_member_id)->delete();
                        $store_or_update = StandingCommitteeMember::find(@$request->standing_committee_member_id[$i]);
                        if($store_or_update){
                            $store_or_update = $store_or_update;
                        }else{
                            $store_or_update = new StandingCommitteeMember();
                        }
                        $store_or_update->standing_committee_id = $id;
                        $store_or_update->user_id               = $request->user_id[$i];
                        $store_or_update->designation_id        = $request->designation_id[$i];
                        $store_or_update->status                = $request->status[$i];
                        $store_or_update->status_inactive_date  = (($request->status[$i]==0)?now():null);
                        $done[]                                 = $store_or_update->save();
                    }                  
                    $new_ids = $request->user_id;
                    if(!array_diff($existing_ids,$new_ids) == array_diff($new_ids,$existing_ids) ){
                        $data = array(
                            'committee_id'=>$id,
                            'member_ids'=> implode(',',$new_ids),
                            'created_at'=> now()
                        );
                        DB::table('log_standing_committees')->insert($data);
                    }
                }
            }
            if (count($done) > 0 || $updateDone > 0) {
                if (isApi()) {
                    $response['status']   = 'success';
                    $response['message']  = 'Successfully updated';
                    return response()->json($response);
                }
                return response()->json([
                    'status'=>'success',
                    'message'=>'Successfully updated',
                    'reload_url'=>route('admin.master_setup.new_standing_committees.index'),
                ]);
            } else {
                if (isApi()) {
                    $response['status']   = 'error';
                    $response['message']  = 'You must upload a Signature';
                    return response()->json($response);
                }
                return response()->json(['status'=>'error','message'=>'Not Successfully updated']);
            }

            // if(count($done) > 0 ){
            //     return redirect()->route('admin.master_setup.new_standing_committees.index')->with('success','Data Saved successfully');
            // }else{
            //     return redirect()->route('admin.master_setup.new_standing_committees.edit')->with('error','Data does not save successfully')->withInput();
            // }
        } catch (\Exception $e) {
            $errorMessage=$e->getMessage();
            $customMessage="Exception! Something went wrong please try again!";

            \Session::flash('error', $customMessage, true);
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
            $existingId = StandingCommitteeMember::where('standing_committee_id',$id)->first();
            if (isset($existingId->designation_id) && $existingId->designation_id > 0) {
                return response()->json(["status"=>"data_is_used"]);
            }else{
                $fileCat = NewStandingCommittee::find($id);                    
                $status = $fileCat->delete();
                if($status){
                    $fileCat->status = 0;
                    $fileCat->deleted_by = authInfo()->id;
                    $update = $fileCat->update();
                }
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
