<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Frontend\BottomSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Lang;

class BottomSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['bottomSections'] = BottomSection::orderBy( 'id', 'desc' )->get();
        return view( 'frontend.admin.bottom_section.index', $data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view( 'frontend.admin.bottom_section.form' );
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
            'content1Bng'      => 'required',
            'content1Eng'      => 'required',

            'content2Bng'      => 'required',
            'content2Eng'      => 'required',

            'content3Bng'      => 'required',
            'content3Eng'      => 'required',

            'content4Bng'      => 'required',
            'content4Eng'      => 'required',
        ];
        $message = [
            'content1Bng.required'      => 'The content field is required.',
            'content1Eng.required'      => 'The content field is required',

            'content2Bng.required'      => 'The content field is required.',
            'content2Eng.required'      => 'The content field is required',

            'content3Bng.required'      => 'The content field is required.',
            'content3Eng.required'      => 'The content field is required',

            'content4Bng.required'      => 'The content field is required.',
            'content4Eng.required'      => 'The content field is required',
        ];

        $validator = Validator::make( $request->all(), $rules, $message );

        if ( $validator->fails() ) {
            return response()->json( ['status' => 'rulesfail'] );

        }

        DB::beginTransaction();

        try {

            $bottomSection = new BottomSection();
            $bottomSection->fill( $request->all() );

            $result = $bottomSection->save();

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
        $data['editData'] = BottomSection::findOrFail( $id );
        return view( 'frontend.admin.bottom_section.form', $data );
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
            'content1Bng'      => 'required',
            'content1Eng'      => 'required',

            'content2Bng'      => 'required',
            'content2Eng'      => 'required',

            'content3Bng'      => 'required',
            'content3Eng'      => 'required',

            'content4Bng'      => 'required',
            'content4Eng'      => 'required',
        ];
        $message = [
            'content1Bng.required'      => 'The content field is required.',
            'content1Eng.required'      => 'The content field is required',

            'content2Bng.required'      => 'The content field is required.',
            'content2Eng.required'      => 'The content field is required',

            'content3Bng.required'      => 'The content field is required.',
            'content3Eng.required'      => 'The content field is required',

            'content4Bng.required'      => 'The content field is required.',
            'content4Eng.required'      => 'The content field is required',
        ];

        $validator = Validator::make( $request->all(), $rules, $message );

        if ( $validator->fails() ) {
            return response()->json( ['status' => 'rulesfail'] );

        }

        DB::beginTransaction();
        try {

            $bottomSection  = BottomSection::find( $id );
            $data           = $request->all();
            $data['status'] = $request->status ?? 0;
            $result         = $bottomSection->update( $data );
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
            $bottomSection = BottomSection::find( $id );
            $bottomSection->delete();

            return response()->json( ["status" => "success"] );

        } catch ( \Exception $e ) {

            $errorMessage  = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            \Session::flash( 'error', $customMessage, true );
            return response()->json( ["status" => "error"] );
        }
    }
}
