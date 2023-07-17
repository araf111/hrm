<?php

/**
 * Author M. Atoar Rahman
 * Date: 01/02/2021
 * Time: 09:25 AM
 */

namespace App\Http\Controllers\Backend\MasterSetup;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParliamentSessionRequest;
use App\Model\Parliament;
use App\Model\ParliamentSession;
use App\Model\ParliamentSessionAttachment;
use Auth;
use Illuminate\Http\Request;
use App\Model\Notice;

class ParliamentSessionController extends Controller
{
    public function __construct()
    {
        $lDate = date('Y-m-d');
        ParliamentSession::where('date_to', '<', $lDate)->update(['status' => 0]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data        = ParliamentSession::orderBy('id', 'desc')->get();
        $attachments = ParliamentSessionAttachment::all();

        return view('backend.master_setup.parliamentSession.index', compact('data', 'attachments'));
    }

    public function getParlimentSession($parliament_id = null)
    {
        if (!is_null($parliament_id)) {
            $data['parliament_session_list'] = ParliamentSession::where('parliament_id', $parliament_id)
                //->where('status', 1)
                ->get();
        } else {
            $data['parliament_session_list'] = ParliamentSession::where('status', 1)
                ->get();
        }

        if (!empty($data['parliament_session_list'])) {
            foreach ($data['parliament_session_list'] as $d) {
                $d->session_number_bn = \Lang::get($d->session_no);
            }
        }

        if (isApi()) {
            $response['status']    = 'success'; // return data
            $response['message']    = ''; // return data
            $response['api_info']    = $data; // return data
            return response()->json($response);
        }
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data           = new ParliamentSession();
        $parliamentList = Parliament::orderBy('id', 'asc')->get();
        $session_list   = [];
        for ($i = 1; $i <= 20; $i++) {
            $session_list[] = array(
                'id'   => $i,
                'name' => $this->ordinal($i),
            );
        }

        $last_session_date = ParliamentSession::max('date_to');
        $next_session_date = date('Y-m-d',strtotime('+1 day',strtotime($last_session_date)));

        $last_parliament_date = Parliament::max('date_to');
        $upto_parliament_date = date('Y-m-d',strtotime('-1 day',strtotime($last_parliament_date)));

        return view('backend.master_setup.parliamentSession.form', compact('data', 'parliamentList', 'session_list','next_session_date','last_parliament_date','upto_parliament_date'));
    }

    private function ordinal($number)
    {
        $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
        if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
            return $number . 'th';
        } else {
            return $number . $ends[$number % 10];
        }
    }
    //Example Usage

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_old(ParliamentSessionRequest $request)
    {
        try {
            $existing_record = ParliamentSession::where('parliament_id', $request->parliament_id)
                ->where('session_no', $request->session_no)
                ->first();
            if (!empty($existing_record)) {
                return redirect()->back()->with('error', \Lang::get('Data Exist'));
            } else {
                $parliamentSession     = new ParliamentSession();
                $request['created_by'] = authInfo()->id;
                $parliamentSession->fill($request->all());
                $result                = $parliamentSession->save();
                $parliament_session_id = $parliamentSession->id;

                if ($request->hasfile('attachment')) {

                    if ($file = $request->file('attachment')) {
                        // foreach ($files as $file) {
                            $extension = $file->getClientOriginalExtension();
                            $filename  = 'parliament_session' . '_' . time() . random_int(0, 1000) . '.' . $extension; // Make a file name
                            $folder    = public_path('/backend/attachment/'); // Define folder path
                            $file->move($folder, $filename); // Upload image

                            // Insert Data to Attachment Table
                            $sessionAttachment                        = new ParliamentSessionAttachment();
                            $sessionAttachment->parliament_session_id = $parliament_session_id;
                            $sessionAttachment->attachment            = $filename; // Set file path in database to filePath
                            $sessionAttachment->save();
                        // }
                    }
                }
            }


            if ($result) {
                return redirect()->route('admin.master_setup.parliament_sessions.index')->with('success', 'Data Saved successfully');
            } else {
                return redirect()->route('admin.master_setup.parliament_sessions.create')->with('error', 'Data does not save successfully')->withInput();
            }
        } catch (\Exception $e) {
            $errorMessage  = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            \Session::flash('error', $errorMessage, true);
            return redirect()->back()->withInput(); //If you want to go back

        }
    }

    public function store(ParliamentSessionRequest $request)
    {
        try {
            $existing_record = ParliamentSession::where('parliament_id', $request->parliament_id)
                ->where('session_no', $request->session_no)
                ->first();
            $datewise_existing_record = ParliamentSession::where('date_from','>=',$request->date_from)
            ->where('date_to','<=',$request->date_to)->first();

            if (!empty($existing_record) || !empty($datewise_existing_record)) {
                return redirect()->back()->with('error', \Lang::get('Session Exists with the given Timerange'));
            } 
            else {
                $parliamentSession     = new ParliamentSession();
                $request['created_by'] = authInfo()->id;
                $request['declare_date'] = date('Y-m-d',strtotime($request->declare_date));
                $request['date_from'] = date('Y-m-d',strtotime($request->date_from));
                $request['date_to'] = date('Y-m-d',strtotime($request->date_to));
                $parliamentSession->fill($request->all());
                $result                = $parliamentSession->save();
                $parliament_session_id = $parliamentSession->id;

                if ($request->hasfile('attachment')) {

                    if ($file = $request->file('attachment')) {
                        // foreach ($files as $file) {
                            $extension = $file->getClientOriginalExtension();
                            $filename  = 'parliament_session' . '_' . time() . random_int(0, 1000) . '.' . $extension; // Make a file name
                            $folder    = public_path('/backend/attachment/'); // Define folder path
                            $file->move($folder, $filename); // Upload image

                            // Insert Data to Attachment Table
                            $sessionAttachment                        = new ParliamentSessionAttachment();
                            $sessionAttachment->parliament_session_id = $parliament_session_id;
                            $sessionAttachment->attachment            = $filename; // Set file path in database to filePath
                            $sessionAttachment->save();
                        // }
                    }
                }
            }


            if ($result) {
                return redirect()->route('admin.master_setup.parliament_sessions.index')->with('success', \Lang::get('Data Saved successfully'));
            } else {
                return redirect()->route('admin.master_setup.parliament_sessions.create')->with('error', \Lang::get('Data Not Saved'))->withInput();
            }
        } catch (\Exception $e) {
            $errorMessage  = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            \Session::flash('error', $errorMessage, true);
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
        $last_session_date = ParliamentSession::max('date_to');
        $next_session_date = date('Y-m-d',strtotime('+1 day',strtotime($last_session_date)));

        $last_parliament_date = Parliament::max('date_to');
        $upto_parliament_date = date('Y-m-d',strtotime('-1 day',strtotime($last_parliament_date)));

        $data           = ParliamentSession::findOrFail($id);
        $parliamentList = Parliament::orderBy('id', 'asc')->get();
        $attachments    = ParliamentSessionAttachment::where('parliament_session_id', $id)->get();
        $session_list   = [];
        for ($i = 1; $i <= 20; $i++) {
            $session_list[] = array(
                'id'   => $i,
                'name' => $this->ordinal($i),
            );
        }

        return view('backend.master_setup.parliamentSession.form', compact('data', 'parliamentList', 'session_list', 'attachments','next_session_date','last_parliament_date','upto_parliament_date'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ParliamentSessionRequest $request, $id)
    {
        $existing_record = ParliamentSession::where('id', '!=', $id)
            ->where('parliament_id', $request->parliament_id)
            ->where('session_no', $request->session_no)
            ->first();
        
        $datewise_existing_record = ParliamentSession::where('id', '!=', $id)
        ->where('date_from','>=',$request->date_from)
        ->where('date_to','<=',$request->date_to)->first();
        if (!empty($existing_record) || !empty($datewise_existing_record)) {
            return redirect()->back()->with('error', \Lang::get('Session Exists with the given Timerange'));
        } 

        try {
            $parliamentSessionEloquent = ParliamentSession::find($id);
            $data                      = $request->all();
            $data['status']            = $request->status ?? 0;

            //activating certain session
            /// check if any notice data inserted under this session
            if($data['status']){
                $session_data = ParliamentSession::where('status',1)->first();
                if(!empty($session_data)){
                    $notice_data = Notice::where('parliament_session_id',$session_data->id)->first();
                    if(!empty($notice_data)){
                        return redirect()->back()->with('error', \Lang::get('Some Data Exist in Previous Session'));
                    }
                    else{
                        //update all status = 0 except this parliament session
                        DB::table('parliament_sessions')->where(['id!='=>$id])->update(['status'=>0]);
                    }
                }
            }

            $data['declare_date'] = date('Y-m-d',strtotime($request->declare_date));
            $data['date_from'] = date('Y-m-d',strtotime($request->date_from));
            $data['date_to'] = date('Y-m-d',strtotime($request->date_to));

            if ($request->hasfile('attachment')) {

                // Delete Data to Notice Attachment Table
                $sessionAllAttachment = ParliamentSessionAttachment::where('parliament_session_id', $id)->get();
                foreach ($sessionAllAttachment as $attachmentFile) {
                    $folder = public_path('/backend/attachment/');
                    @unlink($folder . $attachmentFile->attachment);
                }
                ParliamentSessionAttachment::where('parliament_session_id', $id)->delete();

                if ($file = $request->file('attachment')) {
                    // foreach ($files as $file) {
                        $extension = $file->getClientOriginalExtension();
                        $filename  = 'parliament_session' . '_' . time() . random_int(0, 1000) . '.' . $extension; // Make a file name
                        $folder    = public_path('/backend/attachment/'); // Define folder path
                        $file->move($folder, $filename); // Upload image

                        // Insert Data to Notice Attachment Table
                        $sessionAttachment                        = new ParliamentSessionAttachment();
                        $sessionAttachment->parliament_session_id = $id;
                        $sessionAttachment->attachment            = $filename; // Set file path in database to filePath
                        $sessionAttachment->save();
                    // }
                }
            }

            $result = $parliamentSessionEloquent->update($data);

            if ($result) {
                return redirect()->route('admin.master_setup.parliament_sessions.index')->with('success', \Lang::get('Data Successfully Updated'));
            } else {
                return redirect()->route('admin.master_setup.parliament_sessions.edit', [$id])->with('error', \Lang::get('Data Successfully not Updated'))->withInput();
            }
        } catch (\Exception $e) {
            dd($e);
            $errorMessage  = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

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
            $parliamentSessionEloquent = ParliamentSession::find($id);
            /* dd($parliamentSessionEloquent);
            if(!empty($parliamentSessionEloquent) && $parliamentSessionEloquent->status==1){
                return response()->json(["error" => \Lang::get('Data Exist')]);
            } */
            $notice_data = Notice::where('parliament_session_id',$id)->first();
            if(!empty($notice_data)){
                //return redirect()->back()->with('error', \Lang::get('Some Data Exist in this Session'));
                return response()->json(["status" => "error"]);
            }
            $parliamentSessionEloquent->delete();
            // Delete Data from Attachment Table
            $sessionAllAttachment = ParliamentSessionAttachment::where('parliament_session_id', $id)->get();
            foreach ($sessionAllAttachment as $attachmentFile) {
                $folder = public_path('/backend/attachment/');
                @unlink($folder . $attachmentFile->attachment);
            }
            ParliamentSessionAttachment::where('parliament_session_id', $id)->delete();
            return response()->json(["status" => "success"]);
        } catch (\Exception $e) {

            $errorMessage  = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            \Session::flash('error', $customMessage, true);
            return response()->json(["status" => "error"]);
        }
    }
}
