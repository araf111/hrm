<?php
/**
 * Author M. Atoar Rahman
 * Date: 10/08/2021
 * Time: 11:40 AM
 */
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Frontend\MpMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Lang;

class MpMessageController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['mpMessages'] = MpMessage::orderBy( 'id', 'desc' )->get();
        return view( 'frontend.admin.mp_message.index', $data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view( 'frontend.admin.mp_message.form' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        $rules = [
            'mpNameBng'  => 'required',
            'mpNameEng'  => 'required',
            'messageBng' => 'required',
            'messageEng' => 'required',
            'photo'      => 'required|mimes:jpg,jpeg,png',
        ];
        $message = [
            'mpNameBng.required'  => 'The Name field is required.',
            'mpNameEng.required'  => 'The Name field is required.',
            'messageBng.required' => 'The Message field is required.',
            'messageEng.required' => 'The Message field is required',
            'photo.required'      => 'The photo field is required',
        ];

        $validator = Validator::make( $request->all(), $rules, $message );

        if ( $validator->fails() ) {
            return response()->json( ['status' => 'rulesfail'] );

        }

        DB::beginTransaction();

        try {

            $mpMessage = new MpMessage();
            $mpMessage->fill( $request->all() );

            if ( $request->hasfile( 'photo' ) ) {
                $files     = $request->file( 'photo' );
                $extension = $files->getClientOriginalExtension();
                $filename  = 'message' . '_' . time() . random_int( 0, 1000 ) . '.' . $extension; // Make a file name
                $folder    = public_path( '/frontend/images/' ); // Define folder path
                $files->move( $folder, $filename ); // Upload image
                $mpMessage->photo = $filename; // Set file path in database to filePath
            }
            $result = $mpMessage->save();

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
        $data['mpMessage'] = MpMessage::where( 'id', $id )->first();
        return view( 'frontend.admin.mp_message.show', $data );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {
        $data['editData'] = MpMessage::findOrFail( $id );
        return view( 'frontend.admin.mp_message.form', $data );
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
            'mpNameBng'  => 'required',
            'mpNameEng'  => 'required',
            'messageBng' => 'required',
            'messageEng' => 'required',
        ];
        $message = [
            'mpNameBng.required'  => 'The Name field is required.',
            'mpNameEng.required'  => 'The Name field is required.',
            'messageBng.required' => 'The Message field is required.',
            'messageEng.required' => 'The Message field is required',
        ];

        $validator = Validator::make( $request->all(), $rules, $message );

        if ( $validator->fails() ) {
            return response()->json( ['status' => 'rulesfail'] );

        }

        DB::beginTransaction();

        try {

            $mpMessage = MpMessage::find( $id );

            $folder = public_path( '/frontend/images/' );

            $data           = $request->all();
            $data['status'] = $request->status ?? 0;

            if ( $request->hasfile( 'photo' ) ) {
                @unlink( $folder . $mpMessage->photo );

                $files     = $request->file( 'photo' );
                $extension = $files->getClientOriginalExtension();
                $filename  = 'message' . '_' . time() . random_int( 0, 1000 ) . '.' . $extension; // Make a file name
                $folder    = public_path( '/frontend/images/' ); // Define folder path
                $files->move( $folder, $filename ); // Upload image
                $data['photo'] = $filename; // Set file path in database to filePath
            }

            $result = $mpMessage->update( $data );

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
            $mpMessage = MpMessage::find( $id );

            $folder = public_path( '/frontend/images/' );
            @unlink( $folder . $mpMessage->photo );

            $mpMessage->delete();

            return response()->json( ["status" => "success"] );

        } catch ( \Exception $e ) {

            $errorMessage  = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            \Session::flash( 'error', $customMessage, true );
            return response()->json( ["status" => "error"] );
        }
    }
}
