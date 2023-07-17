<?php

namespace App\Http\Controllers\Backend\MasterSetup;

use App\Http\Controllers\Controller;
use App\Model\District;
use App\Model\Union;
use App\Model\Upazila;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Lang;
use DataTables;

class UnionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.master_setup.union.index');
        
    }

    public function loadData(){
        // $data['unions'] = Union::orderBy('id', 'asc')->get();
        $data['unions'] = Union::leftJoin('divisions', 'divisions.id', '=', 'unions.division_id')
        ->leftJoin('districts', 'districts.id', '=', 'unions.district_id')
        ->leftJoin('upazilas', 'upazilas.id', '=', 'unions.upazila_id')
        ->select('unions.*', 'upazilas.name as upazilaNameEng', 'upazilas.bn_name as upazilaNameBng', 'districts.name as districtNameEng', 'districts.bn_name as districtNameBng', 'divisions.name as divisionNameEng', 'divisions.bn_name as divisionNameBng')
        ->orderBy('unions.id', 'asc');

        return DataTables::of($data['unions'])
        ->editColumn('upazila_id', function ($row) {
            if (session()->get('language') == 'bn') {
                $row->upazila_id = $row->upazilaNameBng;
            } else {
                $row->upazila_id = $row->upazilaNameEng;
            }
            return $row->upazila_id;
        })
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
            $btn = '<a class="btn btn-sm btn-info" href="' . route('admin.master_setup.unions.edit', $row->id) . '"><i class="fa fa-edit"></i></a>
            <a class="btn btn-sm btn-danger destroy" data-route="' . route('admin.master_setup.unions.destroy', $row->id) . '"><i class="fa fa-trash"></i></a>';

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
        return view('backend.master_setup.union.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'division_id'  => 'required',
            'district_id'  => 'required',
            'upazila_id' => 'required',
            'name' => 'required',
            'bn_name' => 'required',
        ];
        $message = [
            'division_id.required'  => 'The Division field is required.',
            'district_id.required'  => 'The District field is required.',
            'upazila_id.required'  => 'The Upazila field is required.',
            'name.required' => 'The Name field is required.',
            'bn_name.required' => 'The Name field is required',
        ];

        $validator = Validator::make( $request->all(), $rules, $message );

        if ( $validator->fails() ) {
            return response()->json( ['status' => 'rulesfail'] );

        }

        DB::beginTransaction();

        try {

            $union = new Union();
            $union->fill( $request->all() );
            $result = $union->save();
            if ( $result ) {
                DB::commit();
                return response()->json( ['status' => 'success', 'message' => Lang::get( 'Data Successfully Insert' )] );
            } else {
                return response()->json( ['status' => 'error', 'message' => Lang::get( 'Data Successfully not Insert' )] );
            }

        } catch ( \Exception $e ) {
            DB::rollback();
            return response()->json( ['status' => 'error', 'message' => Lang::get( 'Data Successfully not Insert' )] );
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
        $data['union'] = Union::where( 'id', $id )->first();
        return view( 'backend.master_setup.union.show', $data );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['editData'] = Union::findOrFail( $id );
        $data['districtList']   = District::where( 'division_id', $data['editData']->division_id )->orderBy( 'name', 'asc' )->get();
        $data['upazilaList']    = Upazila::where( 'district_id', $data['editData']->district_id )->orderBy( 'name', 'asc' )->get();
        return view( 'backend.master_setup.union.form', $data );
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
        $rules = [
            'division_id'  => 'required',
            'district_id'  => 'required',
            'upazila_id' => 'required',
            'name' => 'required',
            'bn_name' => 'required',
        ];
        $message = [
            'division_id.required'  => 'The Division field is required.',
            'district_id.required'  => 'The District field is required.',
            'upazila_id.required'  => 'The Upazila field is required.',
            'name.required' => 'The Name field is required.',
            'bn_name.required' => 'The Name field is required',
        ];

        $validator = Validator::make( $request->all(), $rules, $message );

        if ( $validator->fails() ) {
            return response()->json( ['status' => 'rulesfail'] );

        }

        DB::beginTransaction();

        try {

            $union = Union::find( $id );
            $data           = $request->all();
            $data['status'] = $request->status ?? 0;
            $result         = $union->update( $data );
            if ( $result ) {
                DB::commit();
                return response()->json( ['status' => 'success', 'message' => Lang::get( 'Data Successfully Updated' )] );
            } else {
                return response()->json( ['status' => 'error', 'message' => Lang::get( 'Data Successfully not Updated' )] );
            }
        } catch ( \Exception $e ) {
            DB::rollback();
            return response()->json( ['status' => 'error', 'message' => Lang::get( 'Data Successfully not Updated' )] );
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
            $union = Union::find( $id );
            $union->delete();

            return response()->json( ["status" => "success"] );

        } catch ( \Exception $e ) {

            $errorMessage  = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            \Session::flash( 'error', $customMessage, true );
            return response()->json( ["status" => "error"] );
        }
    }
}
