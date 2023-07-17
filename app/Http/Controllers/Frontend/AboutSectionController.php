<?php
/**
 * Author M. Atoar Rahman
 * Date: 22/08/2021
 * Time: 09:40 AM
 */
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Frontend\AboutSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Lang;

class AboutSectionController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['aboutSections'] = AboutSection::orderBy( 'id', 'desc' )->get();
        return view( 'frontend.admin.about_section.index', $data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view( 'frontend.admin.about_section.form' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        $rules = [
            'titleBng'        => 'required',
            'titleEng'        => 'required',
            'contentBng'      => 'required',
            'contentEng'      => 'required',
            'videoLink'       => 'required',
            'videoThumbnail'  => 'required|mimes:jpg,jpeg,png',
            'videoBackground' => 'required|mimes:jpg,jpeg,png',
        ];
        $message = [
            'titleBng.required'        => 'The title field is required.',
            'titleEng.required'        => 'The title field is required',
            'contentBng.required'      => 'The content field is required.',
            'contentEng.required'      => 'The content field is required',
            'videoLink.required'       => 'The link field is required.',
            'videoThumbnail.required'  => 'The video thumbnail field is required',
            'videoBackground.required' => 'The video background field is required',
        ];

        $validator = Validator::make( $request->all(), $rules, $message );

        if ( $validator->fails() ) {
            return response()->json( ['status' => 'rulesfail'] );

        }

        DB::beginTransaction();

        try {

            $aboutSection = new AboutSection();
            $aboutSection->fill( $request->all() );

            if ( $request->hasfile( 'videoThumbnail' ) ) {
                $files     = $request->file( 'videoThumbnail' );
                $extension = $files->getClientOriginalExtension();
                $filename  = 'about' . '_' . time() . random_int( 0, 1000 ) . '.' . $extension; // Make a file name
                $folder    = public_path( '/frontend/images/' ); // Define folder path
                $files->move( $folder, $filename ); // Upload image
                $aboutSection->videoThumbnail = $filename; // Set file path in database to filePath
            }
            if ( $request->hasfile( 'videoBackground' ) ) {
                $files     = $request->file( 'videoBackground' );
                $extension = $files->getClientOriginalExtension();
                $filename  = 'about' . '_' . time() . random_int( 0, 1000 ) . '.' . $extension; // Make a file name
                $folder    = public_path( '/frontend/images/' ); // Define folder path
                $files->move( $folder, $filename ); // Upload image
                $aboutSection->videoBackground = $filename; // Set file path in database to filePath
            }
            $result = $aboutSection->save();

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
        $data['editData'] = AboutSection::findOrFail( $id );
        return view( 'frontend.admin.about_section.form', $data );
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
            'titleBng'   => 'required',
            'titleEng'   => 'required',
            'contentBng' => 'required',
            'contentEng' => 'required',
            'videoLink'  => 'required',
        ];
        $message = [
            'titleBng.required'   => 'The title field is required.',
            'titleEng.required'   => 'The title field is required',
            'contentBng.required' => 'The content field is required.',
            'contentEng.required' => 'The content field is required',
            'videoLink.required'  => 'The link field is required.',
        ];

        $validator = Validator::make( $request->all(), $rules, $message );

        if ( $validator->fails() ) {
            return response()->json( ['status' => 'rulesfail'] );

        }

        DB::beginTransaction();

        try {

            $aboutSection = AboutSection::find( $id );

            $folder = public_path( '/frontend/images/' );

            $data           = $request->all();
            $data['status'] = $request->status ?? 0;

            if ( $request->hasfile( 'videoThumbnail' ) ) {
                @unlink( $folder . $aboutSection->videoThumbnail );

                $files     = $request->file( 'videoThumbnail' );
                $extension = $files->getClientOriginalExtension();
                $filename  = 'about' . '_' . time() . random_int( 0, 1000 ) . '.' . $extension; // Make a file name
                $folder    = public_path( '/frontend/images/' ); // Define folder path
                $files->move( $folder, $filename ); // Upload image
                $data['videoThumbnail'] = $filename; // Set file path in database to filePath
            }
            if ( $request->hasfile( 'videoBackground' ) ) {
                @unlink( $folder . $aboutSection->videoBackground );

                $files     = $request->file( 'videoBackground' );
                $extension = $files->getClientOriginalExtension();
                $filename  = 'about' . '_' . time() . random_int( 0, 1000 ) . '.' . $extension; // Make a file name
                $folder    = public_path( '/frontend/images/' ); // Define folder path
                $files->move( $folder, $filename ); // Upload image
                $data['videoBackground'] = $filename; // Set file path in database to filePath
            }

            $result = $aboutSection->update( $data );

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
            $aboutSection = AboutSection::find( $id );

            $folder = public_path( '/frontend/images/' );
            @unlink( $folder . $aboutSection->videoThumbnail );
            @unlink( $folder . $aboutSection->videoBackground );

            $aboutSection->delete();

            return response()->json( ["status" => "success"] );

        } catch ( \Exception $e ) {

            $errorMessage  = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            \Session::flash( 'error', $customMessage, true );
            return response()->json( ["status" => "error"] );
        }
    }
}
