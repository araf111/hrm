<?php
/**
 * Author M. Atoar Rahman
 * Date: 10/08/2021
 * Time: 11:40 AM
 */
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Frontend\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Lang;

class SliderController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['sliders'] = Slider::orderBy( 'id', 'desc' )->get();
        return view( 'frontend.admin.slider.index', $data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view( 'frontend.admin.slider.form' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {

        $rules = [
            'sliderTitleBng' => 'required',
            'sliderTitleEng' => 'required',
            'readMoreLink'   => 'required',
            'photo'          => 'required|mimes:jpg,jpeg,png',
            'logo'           => 'sometimes|mimes:jpg,jpeg,png',
        ];
        $message = [
            'sliderTitleBng.required' => 'The title field is required.',
            'sliderTitleEng.required' => 'The title field is required',
            'readMoreLink.required'   => 'The link field is required.',
            'photo.required'          => 'The photo field is required',
            'logo.sometimes'          => 'The logo field is required',
        ];

        $validator = Validator::make( $request->all(), $rules, $message );

        if ( $validator->fails() ) {
            return response()->json( ['status' => 'rulesfail'] );

        }

        DB::beginTransaction();

        try {

            $slider = new Slider();
            $slider->fill( $request->all() );

            if ( $request->hasfile( 'photo' ) ) {
                $files     = $request->file( 'photo' );
                $extension = $files->getClientOriginalExtension();
                $filename  = 'photo' . '_' . time() . random_int( 0, 1000 ) . '.' . $extension; // Make a file name
                $folder    = public_path( '/frontend/images/slide/' ); // Define folder path
                $files->move( $folder, $filename ); // Upload image
                $slider->photo = $filename; // Set file path in database to filePath
            }
            if ( $request->hasfile( 'logo' ) ) {
                $files     = $request->file( 'logo' );
                $extension = $files->getClientOriginalExtension();
                $filename  = 'logo' . '_' . time() . random_int( 0, 1000 ) . '.' . $extension; // Make a file name
                $folder    = public_path( '/frontend/images/slide/' ); // Define folder path
                $files->move( $folder, $filename ); // Upload image
                $slider->logo = $filename; // Set file path in database to filePath
            }
            $result = $slider->save();

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
        $data['editData'] = Slider::findOrFail( $id );
        return view( 'frontend.admin.slider.form', $data );
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
            'sliderTitleBng' => 'required',
            'sliderTitleEng' => 'required',
            'readMoreLink'   => 'required',
        ];
        $message = [
            'sliderTitleBng.required' => 'The title field is required.',
            'sliderTitleEng.required' => 'The title field is required',
            'readMoreLink.required'   => 'The link field is required.',
        ];

        $validator = Validator::make( $request->all(), $rules, $message );

        if ( $validator->fails() ) {
            return response()->json( ['status' => 'rulesfail'] );

        }

        DB::beginTransaction();

        try {

            $slider = Slider::find( $id );

            $folder = public_path( '/frontend/images/slide/' );

            $data           = $request->all();
            $data['status'] = $request->status ?? 0;

            if ( $request->hasfile( 'photo' ) ) {
                @unlink( $folder . $slider->photo );

                $files     = $request->file( 'photo' );
                $extension = $files->getClientOriginalExtension();
                $filename  = 'photo' . '_' . time() . random_int( 0, 1000 ) . '.' . $extension; // Make a file name
                $folder    = public_path( '/frontend/images/slide/' ); // Define folder path
                $files->move( $folder, $filename ); // Upload image
                $data['photo'] = $filename; // Set file path in database to filePath
            }
            if ( $request->hasfile( 'logo' ) ) {
                @unlink( $folder . $slider->logo );

                $files     = $request->file( 'logo' );
                $extension = $files->getClientOriginalExtension();
                $filename  = 'logo' . '_' . time() . random_int( 0, 1000 ) . '.' . $extension; // Make a file name
                $folder    = public_path( '/frontend/images/slide/' ); // Define folder path
                $files->move( $folder, $filename ); // Upload image
                $data['logo'] = $filename; // Set file path in database to filePath
            }

            $result = $slider->update( $data );

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
            $slider = Slider::find( $id );

            $folder = public_path( '/frontend/images/slide/' );
            @unlink( $folder . $slider->photo );
            @unlink( $folder . $slider->logo );

            $slider->delete();

            return response()->json( ["status" => "success"] );

        } catch ( \Exception $e ) {

            $errorMessage  = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            \Session::flash( 'error', $customMessage, true );
            return response()->json( ["status" => "error"] );
        }
    }
}
