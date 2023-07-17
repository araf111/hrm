<?php

namespace App\Http\Controllers\Backend\MasterSetup;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConstituencyRequest;
use App\Model\Constituency;
use App\Model\District;
use App\Model\Division;
use App\Model\Parliament;
use App\Model\Union;
use App\Model\Upazila;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ConstituencyController extends Controller {

    public function __construct() {

    }

    public function index() {

        $current_parliament_data = Parliament::where( 'status', 1 )->orderBy( 'id', 'desc' )->first();
        $data['upazilas']        = Upazila::orderBy( 'id', 'asc' )->get();
        $data['unions']          = Union::orderBy( 'id', 'asc' )->get();
        $data['constituencies']  = Constituency::where( 'parliamentNumber', $current_parliament_data->parliament_number )->orderBy( 'number', 'asc' )->get();

        return view( 'backend.master_setup.constituency.index', $data );
    }

    public function create( Request $request ) {
        $data           = new Constituency();
        $title          = "Create";
        $parliamentList = Parliament::orderBy( 'id', 'desc' )->get();
        $divisionList   = Division::orderBy( 'name', 'asc' )->get();
        $districtList   = array();
        $upazilaList    = array();
        $unionList      = array();

        return view( 'backend.master_setup.constituency.form', compact( 'data', 'title', 'parliamentList', 'unionList', 'upazilaList', 'districtList', 'divisionList' ) );

    }

    public function store( ConstituencyRequest $request ) {

        /* $messages = [
            'number.unique' => 'Number and parliamentNumber should be unique!',
        ];
        
        Validator::make($request->all(), [
            'number' => [
                'required',
                Rule::unique('constituencies')->where(function ($query) use($request) {
                    return $query->where('parliamentNumber', $request->parliamentNumber)
                    ->where('number', $request->number);
                }),
            ],
        ],
        $messages
        ); */
        
        try {
            $existing_data = Constituency::where(array('parliamentNumber'=>$request->parliamentNumber,'number'=>$request->number))->first();
            if(!empty($existing_data)){
                return redirect()->back()->with('error', \Lang::get('Data Exist').' '.\Lang::get('Parliament Number').' '.digitDateLang($request->parliamentNumber).' '.\Lang::get('Bangladesh Number').' '.digitDateLang($request->number));
            }

            if ( $request->isMethod( "POST" ) ) {
                $district              = new Constituency();
                $request['created_by'] = authInfo()->id;
                $request['upazila_id'] = implode( $request->input( 'upazila_ids' ) );
                $request['union_id'] = implode( $request->input( 'union_ids' ) );
                $district->fill( $request->all() );
                $result = $district->save();

                if ( $result ) {
                    return redirect()->route( 'admin.master_setup.constituencies.index' )->with( 'success', 'Data Saved successfully' );
                } else {
                    return redirect()->route( 'admin.master_setup.constituencies.create' )->with( 'error', 'Data does not save successfully' )->withInput();
                }
            }
        } catch ( \Exception $e ) {
            $errorMessage  = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            \Session::flash( 'error', $customMessage, true );
            return redirect()->back()->withInput(); //If you want to go back

        }

    }

    public function edit( $id ) {
        $data['data']           = Constituency::findOrFail( $id );
        $data['parliamentList'] = Parliament::orderBy( 'id', 'desc' )->get();
        $data['divisionList']   = Division::orderBy( 'name', 'asc' )->get();
        $data['districtList']   = District::where( 'division_id', $data['data']->division_id )->orderBy( 'name', 'asc' )->get();
        $data['upazilaList']    = Upazila::where( 'district_id', $data['data']->district_id )->orderBy( 'name', 'asc' )->get();
        $data['unionList']      = Union::orderBy('name', 'asc')->get();

        // dd($data['data']);

        return view( 'backend.master_setup.constituency.form', $data );

    }

    public function update( ConstituencyRequest $request, $id ) {
        //dd($request->all());
        $existing_data = Constituency::where('id','!=',$id)->where(array('parliamentNumber'=>$request->parliamentNumber,'number'=>$request->number))->first();
            if(!empty($existing_data)){
                return redirect()->back()->with('error', \Lang::get('Data Exist').' '.\Lang::get('Parliament Number').' '.digitDateLang($request->parliamentNumber).' '.\Lang::get('Bangladesh Number').' '.digitDateLang($request->number));
            }
        try {
            if ( $request->isMethod( "PUT" ) ) {

                $ConstituencyEloquent  = Constituency::find( $id );
                $request['updated_by'] = authInfo()->id;
                $request['upazila_id'] = implode( $request->input( 'upazila_ids' ) );
                $request['union_id']   = implode( $request->input( 'union_ids' ) );
                $result                = $ConstituencyEloquent->update( $request->all() );

                if ( $result ) {
                    return redirect()->route( 'admin.master_setup.constituencies.index' )->with( 'success', 'Data Updated successfully' );
                } else {
                    return redirect()->route( 'admin.master_setup.constituencies.edit', [$id] )->with( 'error', 'Data does not update successfully' )->withInput();
                }
            }
        } catch ( \Exception $e ) {

            $errorMessage  = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            \Session::flash( 'error', $customMessage, true );
            return redirect()->back()->withInput(); //If you want to go back
        }
    }

    public function destroy( $id ) {
        try {
            $ConstituencyEloquent = Constituency::find( $id );
            $ConstituencyEloquent->delete();
            return response()->json( ["status" => "success"] );

        } catch ( \Exception $e ) {

            $errorMessage  = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            \Session::flash( 'error', $customMessage, true );
            return response()->json( ["status" => "error"] );
        }
    }

}
