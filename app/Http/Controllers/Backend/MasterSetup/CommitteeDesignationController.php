<?php

namespace App\Http\Controllers\Backend\MasterSetup;

use App\Model\Profile;
// use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
use App\Model\Ministry;
use App\Model\Parliament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\CommitteeDesignation;
use App\Http\Controllers\Controller;
use App\Model\StandingCommitteeMember;
use Illuminate\Support\Facades\Validator;

class CommitteeDesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {     
        $data['committeeDesignation'] = CommitteeDesignation::orderBy('id', 'asc')->get();
        return view('backend.master_setup.committee_designation.index', $data);
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        echo "create";
        return view('backend.master_setup.committee_designation.create');
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
            'name_bn' => 'required',
            'name_en' => 'required'
            
        ]);
        if ($validator->fails()) {
            if (isApi()) {
                $response['validation'] = $validator;
                return response()->json($response);
            }
            return response()->json($validator);
        }
        try {
            $committeeDesignation = new CommitteeDesignation();
             $committeeDesignation['name_bn'] =  $request->name_bn;
             $committeeDesignation['name_en'] =  $request->name_en;
             $committeeDesignation['status'] =  $request->status;
             $result = $committeeDesignation->save();
            if($result){
                return response()->json([
                    'status'=>'success',
                    'message'=>'Successfully created',
                    'reload_url'=>route('admin.master_setup.committee_designation.index'),
                ]);
            }else{
                return redirect()->route('admin.master_setup.committee_designation.create')->with('error','Data does not save successfully')->withInput();
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
        // echo "edit";
        // echo $id;
        $data['committeeDesignation'] = CommitteeDesignation::find($id);
        return view('backend.master_setup.committee_designation.edit', $data);
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
        try {
            $validator = Validator::make($request->all(), [        
                'name_bn' => 'required',
                'name_en' => 'required'
            ]);
            if ($validator->fails()) {
                if (isApi()) {
                    $response['validation'] = $validator;
                    return response()->json($response);
                }
                return response()->json($validator);
            }
            $committeeDesignation = CommitteeDesignation::find($id);
            $committeeDesignation['name_bn'] = $request->name_bn;
            $committeeDesignation['name_en'] = $request->name_en;
           $committeeDesignation['status'] = $request->status;
            $result = $committeeDesignation->update();
            if ($result == true) {

                if (isApi()) {
                    $response['status']   = 'success';
                    $response['message']  = 'Successfully updated';
                    return response()->json($response);
                }    
                return response()->json([
                    'status'=>'success',
                    'message'=>'Successfully updated',
                    'reload_url'=>route('admin.master_setup.committee_designation.index'),
                ]);
            } else {
    
                if (isApi()) {
    
                    $response['status']   = 'error';
                    $response['message']  = 'You must upload a Signature';
                    return response()->json($response);
                }
    
                return response()->json(['status'=>'error','message'=>'Not Successfully updated']);
            }

            // if ($result) {
            //     return redirect()->route('admin.master_setup.committee_designation.index')->with('success', 'Data update successfully');
            // } else {
            //     return redirect()->route('admin.master_setup.committee_designation.edit')->with('error', 'Data does not update successfully')->withInput();
            // }
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
            $existingId = StandingCommitteeMember::where('designation_id',$id)->first();
            if (isset($existingId->designation_id) && $existingId->designation_id > 0) {
                return response()->json(["status"=>"data_is_used"]);
            }else{
                $fileCat = CommitteeDesignation::find($id);                    
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
