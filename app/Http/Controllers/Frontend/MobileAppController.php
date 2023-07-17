<?php
/**
 * Author M. Atoar Rahman
 * Date: 10/08/2021
 * Time: 11:40 AM
 */
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Frontend\MobileApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Lang;

class MobileAppController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['mobileApps'] = MobileApp::orderBy( 'id', 'desc' )->get();
        return view( 'frontend.admin.mobile_apps.index', $data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view( 'frontend.admin.mobile_apps.form' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {

        $rules = [
            'titleBng'       => 'required',
            'titleEng'       => 'required',
            'contentBng'     => 'required',
            'contentEng'     => 'required',
            'googlePlayLink' => 'required',
            'appStoreLink'   => 'required',
            'googlePlayLogo' => 'required|mimes:jpg,jpeg,png',
            'appStoreLogo'   => 'required|mimes:jpg,jpeg,png',
            'photo'          => 'required|mimes:jpg,jpeg,png',
        ];
        $message = [
            'titleBng.required'       => 'The title field is required.',
            'titleEng.required'       => 'The title field is required.',
            'contentBng.required'     => 'The content field is required.',
            'contentEng.required'     => 'The content field is required.',
            'googlePlayLink.required' => 'The link field is required.',
            'googlePlayLink.required' => 'The link field is required',
            'googlePlayLogo.required' => 'The logo field is required',
            'appStoreLogo.required'   => 'The logo field is required',
            'photo.required'          => 'The photo field is required',
        ];

        $validator = Validator::make( $request->all(), $rules, $message );

        if ( $validator->fails() ) {
            return response()->json( ['status' => 'rulesfail'] );

        }

        DB::beginTransaction();

        try {

            $mobileApp = new MobileApp();
            $mobileApp->fill( $request->all() );

            if ( $request->hasfile( 'googlePlayLogo' ) ) {
                $files     = $request->file( 'googlePlayLogo' );
                $extension = $files->getClientOriginalExtension();
                $filename  = 'app' . '_' . time() . random_int( 0, 1000 ) . '.' . $extension; // Make a file name
                $folder    = public_path( '/frontend/images/' ); // Define folder path
                $files->move( $folder, $filename ); // Upload image
                $mobileApp->googlePlayLogo = $filename; // Set file path in database to filePath
            }
            if ( $request->hasfile( 'appStoreLogo' ) ) {
                $files     = $request->file( 'appStoreLogo' );
                $extension = $files->getClientOriginalExtension();
                $filename  = 'app' . '_' . time() . random_int( 0, 1000 ) . '.' . $extension; // Make a file name
                $folder    = public_path( '/frontend/images/' ); // Define folder path
                $files->move( $folder, $filename ); // Upload image
                $mobileApp->appStoreLogo = $filename; // Set file path in database to filePath
            }
            if ( $request->hasfile( 'photo' ) ) {
                $files     = $request->file( 'photo' );
                $extension = $files->getClientOriginalExtension();
                $filename  = 'app' . '_' . time() . random_int( 0, 1000 ) . '.' . $extension; // Make a file name
                $folder    = public_path( '/frontend/images/' ); // Define folder path
                $files->move( $folder, $filename ); // Upload image
                $mobileApp->photo = $filename; // Set file path in database to filePath
            }
            $result = $mobileApp->save();

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
        $data['editData'] = MobileApp::findOrFail( $id );
        return view( 'frontend.admin.mobile_apps.form', $data );
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
            'titleBng'       => 'required',
            'titleEng'       => 'required',
            'contentBng'     => 'required',
            'contentEng'     => 'required',
            'googlePlayLink' => 'required',
            'appStoreLink'   => 'required',
        ];
        $message = [
            'titleBng.required'       => 'The title field is required.',
            'titleEng.required'       => 'The title field is required.',
            'contentBng.required'     => 'The content field is required.',
            'contentEng.required'     => 'The content field is required.',
            'googlePlayLink.required' => 'The link field is required.',
            'googlePlayLink.required' => 'The link field is required',
        ];

        $validator = Validator::make( $request->all(), $rules, $message );

        if ( $validator->fails() ) {
            return response()->json( ['status' => 'rulesfail'] );

        }

        DB::beginTransaction();

        try {

            $mobileApp = MobileApp::find( $id );

            $folder = public_path( '/frontend/images/' );

            $data           = $request->all();
            $data['status'] = $request->status ?? 0;

            if ( $request->hasfile( 'googlePlayLogo' ) ) {
                @unlink( $folder . $mobileApp->googlePlayLogo );

                $files     = $request->file( 'googlePlayLogo' );
                $extension = $files->getClientOriginalExtension();
                $filename  = 'app' . '_' . time() . random_int( 0, 1000 ) . '.' . $extension; // Make a file name
                $folder    = public_path( '/frontend/images/' ); // Define folder path
                $files->move( $folder, $filename ); // Upload image
                $data['googlePlayLogo'] = $filename; // Set file path in database to filePath
            }
            if ( $request->hasfile( 'appStoreLogo' ) ) {
                @unlink( $folder . $mobileApp->appStoreLogo );

                $files     = $request->file( 'appStoreLogo' );
                $extension = $files->getClientOriginalExtension();
                $filename  = 'app' . '_' . time() . random_int( 0, 1000 ) . '.' . $extension; // Make a file name
                $folder    = public_path( '/frontend/images/' ); // Define folder path
                $files->move( $folder, $filename ); // Upload image
                $data['appStoreLogo'] = $filename; // Set file path in database to filePath
            }
            if ( $request->hasfile( 'photo' ) ) {
                @unlink( $folder . $mobileApp->photo );

                $files     = $request->file( 'photo' );
                $extension = $files->getClientOriginalExtension();
                $filename  = 'app' . '_' . time() . random_int( 0, 1000 ) . '.' . $extension; // Make a file name
                $folder    = public_path( '/frontend/images/' ); // Define folder path
                $files->move( $folder, $filename ); // Upload image
                $data['photo'] = $filename; // Set file path in database to filePath
            }

            $result = $mobileApp->update( $data );

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
            $mobileApp = MobileApp::find( $id );

            $folder = public_path( '/frontend/images/' );
            @unlink( $folder . $mobileApp->googlePlayLogo );
            @unlink( $folder . $mobileApp->appStoreLogo );
            @unlink( $folder . $mobileApp->photo );

            $mobileApp->delete();

            return response()->json( ["status" => "success"] );

        } catch ( \Exception $e ) {

            $errorMessage  = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            \Session::flash( 'error', $customMessage, true );
            return response()->json( ["status" => "error"] );
        }
    }
}
