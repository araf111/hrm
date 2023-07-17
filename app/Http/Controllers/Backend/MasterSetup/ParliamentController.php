<?php
/**
 * Author M. Atoar Rahman
 * Date: 01/02/2021
 * Time: 09:25 AM
 */
namespace App\Http\Controllers\Backend\MasterSetup;

use App\Model\User;
use App\Model\Parliament;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ParliamentRequest;
use Auth;
use App\Model\ParliamentSession;

class ParliamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Parliament::orderBy('id', 'desc')->get();

        if (isApi()) {
            if(!empty($data)){
                foreach($data as $d){
                    $d->parliament_number_bn = \Lang::get($d->parliament_number);
                }
            }
            $response['status']    = 'success'; // return data
            $response['message']    = ''; // return data
            $response['api_info']    = $data; // return data
            return response()->json($response);
        }

        return view('backend.master_setup.parliament.index', compact('data'));
    }

    public function lastParliament(){
        $parliament = Parliament::orderBy('parliament_number', 'desc')->first();

        return response()->json(array(
            'data' => $parliament,
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = new Parliament();

        $last_parliament_date = Parliament::max('date_to');
        $next_parliament_date = date('Y-m-d',strtotime('+1 day',strtotime($last_parliament_date)));

        $last_parliament_date = Parliament::max('date_to');
        $upto_parliament_date = date('Y-m-d',strtotime('-1 day',strtotime($last_parliament_date)));

        return view('backend.master_setup.parliament.form', compact('data','next_parliament_date','last_parliament_date','upto_parliament_date'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParliamentRequest $request)
    {
        try {
            //dd($request->all());
            $request->date_from = date('Y-m-d',strtotime($request->date_from));
            $request->date_to = date('Y-m-d',strtotime($request->date_to));
            $existing_record = Parliament::where('parliament_number',$request->parliament_number)->first();
            
            if (!empty($existing_record)) {
                return redirect()->back()->with('error', \Lang::get('Data Exist'));
            } 

            $datewise_existing_record = Parliament::where('date_from','>=',$request->date_from)
            ->where('date_to','<=',$request->date_to)->first();

            if (!empty($datewise_existing_record)) {
                return redirect()->back()->with('error', \Lang::get('Parliament Exists with the given Timerange'));
            } 
           /*  if(!empty($existing_record)){
                return redirect()->route('admin.master_setup.parliaments.create')->with('error',\Lang::get('Data Exist'));
            } */
            else{
                $parliament = new Parliament();
                $parliament->fill($request->all());
                $result = $parliament->save();
            }
            /* $parliament = new Parliament();
            $parliament->parliament_number = $request->parliament_number;
            $parliament->date_from = $request->date_from;
            $parliament->date_to = $request->date_to;
            $parliament->fill($request->all());
            $result = $parliament->save(); */

            if($result){
                return redirect()->route('admin.master_setup.parliaments.index')->with('success',\Lang::get('Data Saved successfully'));
            }else{
                return redirect()->route('admin.master_setup.parliaments.create')->with('error',\Lang::get('Data Not Saved'))->withInput();
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
        $data = Parliament::findOrFail($id);

        $last_parliament_date = Parliament::max('date_to');
        $next_parliament_date = date('Y-m-d',strtotime('+1 day',strtotime($last_parliament_date)));

        $last_parliament_date = Parliament::max('date_to');
        $upto_parliament_date = date('Y-m-d',strtotime('-1 day',strtotime($last_parliament_date)));

        return view('backend.master_setup.parliament.form', compact('data','next_parliament_date','last_parliament_date','upto_parliament_date'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ParliamentRequest $request, $id) {

        //dd($request->all());
        $request->date_from = date('Y-m-d',strtotime($request->date_from));
        $request->date_to = date('Y-m-d',strtotime($request->date_to));
        $existing_record = Parliament::where('parliament_number',$request->parliament_number)
        ->where('id','!=',$id)
        ->first();

        if (!empty($existing_record)) {
            return redirect()->back()->with('error', \Lang::get('Data Exist'));
        }

        $datewise_existing_record = Parliament::where('id', '!=', $id)
        ->where('date_from','>=',$request->date_from)
        ->where('date_to','<=',$request->date_to)->first();

        if (!empty($datewise_existing_record)) {
            return redirect()->back()->with('error', \Lang::get('Parliament Exists with the given Timerange'));
        } 
            /* if(!empty($existing_record)){
                return redirect()->back()->with('error', \Lang::get('Data Exist'));
            } */

        try {
            $parliamentEloquent = Parliament::find($id);
            $data = $request->all();
            $data['status']= $request->status ?? 0;
            $data['date_from'] = date('Y-m-d',strtotime($request->date_from));
            $data['date_to'] = date('Y-m-d',strtotime($request->date_to));
            
            if($data['status']){
                $parliament_data = Parliament::where('status',1)->first();
                if(!empty($parliament_data)){
                    $session_data = ParliamentSession::where('parliament_id',$parliament_data->id)->first();
                    if(!empty($session_data)){
                        return redirect()->back()->with('error', \Lang::get('Some Data Exist in Previous Session'));
                    }
                    else{
                        //update all status = 0 except this parliament session
                        DB::table('parliaments')->where(['id!='=>$id])->update(['status'=>0]);
                    }
                }
            }

            $result = $parliamentEloquent->update($data);

            if($result){
                return redirect()->route('admin.master_setup.parliaments.index')->with('success',\Lang::get('Data Successfully Updated'));
            }else{
                return redirect()->route('admin.master_setup.parliaments.edit', [$id])->with('error',\Lang::get('Data Successfully not Updated'))->withInput();
            }
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

            $parliament = Parliament::find($id);
            if(!empty($parliament) && $parliament->status==1){
                return response()->json(["error" => \Lang::get('Data Exist')]);
            }
            $parliament->delete();
            return response()->json(["status"=>"success"]);

        } catch (\Exception $e) {

            $errorMessage=$e->getMessage();
            $customMessage="Exception! Something went wrong please try again!";

            \Session::flash('error', $customMessage, true);
            return response()->json(["status"=>"error"]);
        }
    }
}
