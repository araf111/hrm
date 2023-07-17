<?php
/**
 * Author M. Atoar Rahman
 * Date: 21/01/2021
 * Time: 11:40 AM
 */

namespace App\Http\Controllers\Backend\MasterSetup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\User;
use App\Model\Upazila;
use App\Model\District;
use App\Model\Division;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpazilaRequest;
use Auth;
use Yajra\DataTables\DataTables;

class UpazilaController extends Controller
{
    public function __construct()
    {

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Upazila::orderBy('id', 'desc')->get();
        return view('backend.master_setup.upazila.index', compact('data'));
    }

    public function loadData(){
        // $data['upazilas'] = Upazila::orderBy('id', 'asc')->get();

        $data['upazilas'] = Upazila::leftJoin('districts', 'districts.id', '=', 'upazilas.district_id')
        ->leftJoin('divisions', 'divisions.id', '=', 'upazilas.division_id')
        ->select('upazilas.*', 'districts.name as districtNameEng', 'districts.bn_name as districtNameBng', 'divisions.name as divisionNameEng', 'divisions.bn_name as divisionNameBng')
        ->orderBy('upazilas.id', 'asc');

        return DataTables::of($data['upazilas'])
        ->editColumn('district_id', function ($row) {
            if (session()->get('language') == 'bn') {
                $row->district_id = $row->districtNameBng;
            } else {
                $row->district_id = $row->districtNameEng;
            }
            return $row->district_id;
        })
        ->editColumn('division_id', function ($row) {
            if (session()->get('language') == 'bn') {
                $row->division_id = $row->divisionNameBng;
            } else {
                $row->division_id = $row->divisionNameEng;
            }
            return $row->division_id;
        })
        ->editColumn('status', function ($row) {
            if ($row->status == 1) {
                return '<span class="badge badge-success pt-1">' . \Lang::get('Active') . '</span>';
            } else {
                return '<span class="badge badge-danger pt-1">' . \Lang::get('Inactive') . '</span>';
            }
        })
        ->addColumn('action', function ($row) {
            $btn = '<a class="btn btn-sm btn-info" href="' . route('admin.master_setup.upazilas.edit', $row->id) . '"><i class="fa fa-edit"></i></a>
            <a class="btn btn-sm btn-danger destroy" data-route="' . route('admin.master_setup.upazilas.destroy', $row->id) . '"><i class="fa fa-trash"></i></a>';

            return $btn;
        })
        ->addIndexColumn()
        ->escapeColumns([]) // to render html
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = new Upazila();
        $title="Create";
        $districtList = District::orderBy('name', 'asc')->get();
        $divisionList = Division::orderBy('name', 'asc')->get();
        
        return view('backend.master_setup.upazila.form', compact('data', 'title', 'districtList', 'divisionList'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpazilaRequest $request) {

        //print_r($request->all());
            //exit;

        try {
            if ($request->isMethod("POST")) {
                $upazila = new Upazila();
                $request['created_by']= authInfo()->id;
                //$request['status']= 1;
                $upazila->fill($request->all());
                $result = $upazila->save();

                if($result){
                    return redirect()->route('admin.master_setup.upazilas.index')->with('success','Data Saved successfully');
                }else{
                    return redirect()->route('admin.master_setup.upazilas.create')->with('error','Data does not save successfully')->withInput();
                }
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
        $data = Upazila::findOrFail($id);
        $title ="Edit";

        $districtList = District::orderBy('name', 'asc')->get();
        $divisionList = Division::orderBy('name', 'asc')->get();

        return view('backend.master_setup.upazila.form', compact('data', 'title', 'districtList', 'divisionList'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpazilaRequest $request, $id) {

        try {
            if ($request->isMethod("PUT")) {
                //Process One
                $upazilaEloquent = Upazila::find($id);
                $request['updated_by']= authInfo()->id;
                $result = $upazilaEloquent->update($request->all());

                if($result){
                    return redirect()->route('admin.master_setup.upazilas.index')->with('success','Data Updated successfully');
                }else{
                    return redirect()->route('admin.master_setup.upazilas.edit', [$id])->with('error','Data does not update successfully')->withInput();
                }
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
     * @param  \App\Model\Upazila
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $upazilaEloquent = Upazila::find($id);
            $upazilaEloquent->delete();
            return response()->json(["status"=>"success"]);
        } catch (\Exception $e) {

            $errorMessage=$e->getMessage();
            $customMessage="Exception! Something went wrong please try again!";

            \Session::flash('error', $customMessage, true);
            return response()->json(["status"=>"error"]);
        }
    }
}
