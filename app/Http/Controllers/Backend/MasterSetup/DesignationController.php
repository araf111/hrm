<?php
/**
 * Author M. Atoar Rahman
 * Date: 24/01/2021
 * Time: 11:40 AM
 */
namespace App\Http\Controllers\Backend\MasterSetup;

//use App\Traits\DesignationTrait;
use Illuminate\Http\Request;
use App\Model\Designation;
use App\Http\Controllers\Controller;
use App\Http\Requests\DesignationRequest;
use Yajra\DataTables\Facades\DataTables;
use Auth;

class DesignationController extends Controller
{
    //use DesignationTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $data['allData'] = Designation::all(); //$this->all();

        return view('backend.master_setup.designation.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.master_setup.designation.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Designation();
        $data->name = $request->name;
        $data->name_bn = $request->name_bn;
        $done = $data->save();
       // $result = $this->creationDesignation($request);


        if ($done) {
            return redirect()->route('admin.master_setup.designations.index')->with('success', \Lang::get('Data Saved successfully'));
        } else {
            return redirect()->route('admin.master_setup.designations.index')->with('error', \Lang::get('Data Not Saved'));
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
        $data['editData'] =  Designation::find($id);  //$this->getDesignation($id);
        return view('backend.master_setup.designation.form', $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $data = Designation::find($id);
        $data->name = $request->name;
        $data->name_bn = $request->name_bn;
        $done = $data->update();

        //$result = $this->creationDesignation($request, $id);
        if ($done) {
            return redirect()->route('admin.master_setup.designations.index')->with('success', \Lang::get('Data Saved successfully'));
        } else {
            return redirect()->route('admin.master_setup.designations.index')->with('error', \Lang::get('Data Not Saved'));
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
            $designation = Designation::find($id);
            $designation->delete();
            //return response()->json(["status"=>"data_is_used"]);
            return response()->json(["status"=>"success"]);
        } catch (\Exception $e) {
            $errorMessage=$e->getMessage();
            $customMessage="Exception! Something went wrong please try again!";

            \Session::flash('error', $customMessage, true);
            return response()->json(["status"=>"error"]);
        }
    }
}
