<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/12/20
 * Time: 11:40 AM
 */

namespace App\Http\Controllers\Backend\MasterSetup;


use App\Model\District;
use App\Model\Division;
use App\Http\Controllers\Controller;

use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Http\Requests\DistrictRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Auth;

class DistrictController extends Controller
{

    public function __construct()
    {

    }


    // Author Rajan Bhatta

    public function index()
    {
        $data = District::orderBy('id', 'desc')->get();

        return view('backend.master_setup.district.index', compact('data'));
    }

    public function loadData(){
        // $data['districts'] = District::orderBy('id', 'asc')->get();

        $data['districts'] = District::leftJoin('divisions', 'divisions.id', '=', 'districts.division_id')
        ->select('districts.*', 'divisions.name as divisionNameEng', 'divisions.bn_name as divisionNameBng')
        ->orderBy('districts.id', 'asc');

        // dd($data['districts']);

        return DataTables::of($data['districts'])

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
            $btn = '<a class="btn btn-sm btn-info" href="' . route('admin.master_setup.districts.edit', $row->id) . '"><i class="fa fa-edit"></i></a>
            <a class="btn btn-sm btn-danger destroy" data-route="' . route('admin.master_setup.districts.destroy', $row->id) . '"><i class="fa fa-trash"></i></a>';

            return $btn;
        })
        ->addIndexColumn()
        ->escapeColumns([]) // to render html
        ->make(true);
    }


    public function create()
    {
        $data=new District();
        $title="Create";

        $divisionList =Division::orderBy('name', 'asc')->get();

        return view('backend.master_setup.district.form', compact('data', 'title', 'divisionList'));

    }

    public function store(Request $request) {

        // dd($request->all());
        // validation
        $rules = [
            'name' =>[
                'required',
                Rule::unique('districts')->ignore($request->id, 'id'),
            ],
           'bn_name' =>'required',
           'division_id' =>'required',
           'status' =>'required',
        ];
        $message = [
            'name.required' => 'English Name is required!',
            'bn_name.required' => 'Bangla Name is required!',
            'name.unique' => 'Name already exists!',
            'division_id.required' => 'Division is required!',
            'status.required' => 'Status is required!',
        ];


        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            if ($request->isMethod("POST")) {
                $district = new District();
                $request['created_by']= authInfo()->id;
                $district->fill($request->all());
                $result=$district->save();

                if($result){
                    return redirect()->route('admin.master_setup.districts.index')->with('success','Data Saved successfully');
                }else{
                    return redirect()->route('admin.master_setup.districts.create')->with('error','Data does not save successfully')->withInput();
                }
            }
        } catch (\Exception $e) {
            $errorMessage=$e->getMessage();
            $customMessage="Exception! Something went wrong please try again!";

            \Session::flash('error', $errorMessage, true);
            return redirect()->back()->withInput(); //If you want to go back

        }

    }


    public function edit($id)
    {
        $data=District::findOrFail($id);
        $title="Edit";

        $divisionList =Division::orderBy('name', 'asc')->get();
        return view('backend.master_setup.district.form', compact('data', 'title', 'divisionList'));

    }

    public function update(Request $request, $id) {

        // validation
        $rules = [
            'name' =>'required|unique:districts,districts.name,'.$id,
           'bn_name' =>'required',
           'division_id' =>'required',
           'status' =>'required',
        ];
        $message = [
            'name.required' => 'English Name is required!',
            'bn_name.required' => 'Bangla Name is required!',
            'name.unique' => 'Name already exists!',
            'division_id.required' => 'Division is required!',
            'status.required' => 'Status is required!',
        ];


        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            if ($request->isMethod("PUT")) {

                $districtEloquent = District::find($id);
                $request['updated_by']= authInfo()->id;
                $result = $districtEloquent->update($request->all());

                if($result){
                    return redirect()->route('admin.master_setup.districts.index')->with('success','Data Updated successfully');
                }else{
                    return redirect()->route('admin.master_setup.districts.edit', [$id])->with('error','Data does not update successfully')->withInput();
                }
            }
        } catch (\Exception $e) {

            $errorMessage=$e->getMessage();
            $customMessage="Exception! Something went wrong please try again!";

            \Session::flash('error', $customMessage, true);
            return redirect()->back()->withInput(); //If you want to go back
        }
    }

    public function destroy($id)
    {
        try {

            $districtEloquent = District::find($id);
            $districtEloquent->delete();
            return response()->json(["status"=>"success"]);
        } catch (\Exception $e) {

            $errorMessage=$e->getMessage();
            $customMessage="Exception! Something went wrong please try again!";

            \Session::flash('error', $customMessage, true);
            return response()->json(["status"=>"error"]);
        }
    }

}
