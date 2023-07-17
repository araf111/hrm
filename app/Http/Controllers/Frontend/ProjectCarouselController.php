<?php
/**
 * Author M. Atoar Rahman
 * Date: 31/08/2021
 * Time: 11:40 AM
 */
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Frontend\ProjectCarousel;
use App\Model\Frontend\ProjectCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Lang;

class ProjectCarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['projectCarousel'] = ProjectCarousel::orderBy( 'id', 'desc' )->get();
        return view( 'frontend.admin.project_carousel.index', $data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = ProjectCategory::orderBy('id', 'DESC')->get();

        return view( 'frontend.admin.project_carousel.form', $data);
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
            'titleBng' => 'required',
            'titleEng' => 'required',
            'contentBng' => 'required',
            'contentEng' => 'required',
            'category_id' => 'required',
            'photo'          => 'required|mimes:jpg,jpeg,png',
        ];
        $message = [
            'titleBng.required' => 'The title field is required.',
            'titleEng.required' => 'The title field is required',
            'contentBng.required' => 'The content field is required.',
            'contentEng.required' => 'The content field is required',
            'category_id.required' => 'The category field is required',
            'photo.required'          => 'The photo field is required',
        ];

        $validator = Validator::make( $request->all(), $rules, $message );

        if ( $validator->fails() ) {
            return response()->json( ['status' => 'rulesfail'] );

        }

        DB::beginTransaction();

        try {

            $project = new ProjectCarousel();
            $project->fill( $request->all() );

            if ( $request->hasfile( 'photo' ) ) {
                $files     = $request->file( 'photo' );
                $extension = $files->getClientOriginalExtension();
                $filename  = 'project' . '_' . time() . random_int( 0, 1000 ) . '.' . $extension; // Make a file name
                $folder    = public_path( '/frontend/images/project/' ); // Define folder path
                $files->move( $folder, $filename ); // Upload image
                $project->photo = $filename; // Set file path in database to filePath
            }
            $result = $project->save();

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
        $data['project'] = ProjectCarousel::where( 'id', $id )->first();
        return view( 'frontend.single_page.project_view', $data );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['editData'] = ProjectCarousel::findOrFail( $id );
        $data['categories'] = ProjectCategory::orderBy('id', 'DESC')->get();
        return view( 'frontend.admin.project_carousel.form', $data );
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
            'titleBng' => 'required',
            'titleEng' => 'required',
            'contentBng' => 'required',
            'contentEng' => 'required',
            'category_id' => 'required',
        ];
        $message = [
            'titleBng.required' => 'The title field is required.',
            'titleEng.required' => 'The title field is required',
            'contentBng.required' => 'The content field is required.',
            'contentEng.required' => 'The content field is required',
            'category_id.required' => 'The category field is required',
        ];

        $validator = Validator::make( $request->all(), $rules, $message );

        if ( $validator->fails() ) {
            return response()->json( ['status' => 'rulesfail'] );

        }

        DB::beginTransaction();

        try {

            $project = ProjectCarousel::find( $id );

            $folder = public_path( '/frontend/images/project/' );

            $data           = $request->all();
            $data['status'] = $request->status ?? 0;

            if ( $request->hasfile( 'photo' ) ) {
                @unlink( $folder . $project->photo );

                $files     = $request->file( 'photo' );
                $extension = $files->getClientOriginalExtension();
                $filename  = 'project' . '_' . time() . random_int( 0, 1000 ) . '.' . $extension; // Make a file name
                $folder    = public_path( '/frontend/images/project/' ); // Define folder path
                $files->move( $folder, $filename ); // Upload image
                $data['photo'] = $filename; // Set file path in database to filePath
            }

            $result = $project->update( $data );

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
            $project = ProjectCarousel::find( $id );

            $folder = public_path( '/frontend/images/project/' );
            @unlink( $folder . $project->photo );

            $project->delete();

            return response()->json( ["status" => "success"] );

        } catch ( \Exception $e ) {

            $errorMessage  = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            \Session::flash( 'error', $customMessage, true );
            return response()->json( ["status" => "error"] );
        }
    }
}
