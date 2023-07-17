<?php
/**
 * Author M. Atoar Rahman
 * Date: 10/08/2021
 * Time: 11:40 AM
 */
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Frontend\NumberCounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Lang;

class NumberCounterController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['numberCounters'] = NumberCounter::orderBy( 'id', 'desc' )->get();
        return view( 'frontend.admin.number_counter.index', $data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view( 'frontend.admin.number_counter.form' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {

        $rules = [
            'titleBng' => 'required',
            'titleEng' => 'required',
            'number'   => 'required',
        ];
        $message = [
            'titleBng.required' => 'The title field is required.',
            'titleEng.required' => 'The title field is required.',
            'number.required'   => 'The number field is required.',
        ];

        $validator = Validator::make( $request->all(), $rules, $message );

        if ( $validator->fails() ) {
            return response()->json( ['status' => 'rulesfail'] );

        }

        DB::beginTransaction();

        try {

            $numberCounter = new NumberCounter();
            $numberCounter->fill( $request->all() );
            $result = $numberCounter->save();

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
    public function show( $id ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {
        $data['editData'] = NumberCounter::findOrFail( $id );
        return view( 'frontend.admin.number_counter.form', $data );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id ) {
        $rules = [
            'titleBng' => 'required',
            'titleEng' => 'required',
            'number'   => 'required',
        ];
        $message = [
            'titleBng.required' => 'The title field is required.',
            'titleEng.required' => 'The title field is required.',
            'number.required'   => 'The number field is required.',
        ];

        $validator = Validator::make( $request->all(), $rules, $message );

        if ( $validator->fails() ) {
            return response()->json( ['status' => 'rulesfail'] );

        }

        DB::beginTransaction();
        try {

            $numberCounter  = NumberCounter::find( $id );
            $data           = $request->all();
            $data['status'] = $request->status ?? 0;
            $result         = $numberCounter->update( $data );
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
    public function destroy( $id ) {
        try {
            $numberCounter = NumberCounter::find( $id );
            $numberCounter->delete();

            return response()->json( ["status" => "success"] );

        } catch ( \Exception $e ) {

            $errorMessage  = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            \Session::flash( 'error', $customMessage, true );
            return response()->json( ["status" => "error"] );
        }
    }
}
