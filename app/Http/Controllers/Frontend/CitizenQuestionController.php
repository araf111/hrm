<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Frontend\CitizenQuestion;
use App\Model\Parliament;
use App\Model\V2Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Lang;

class CitizenQuestionController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    public function allQuestion() {
        $data['allQuestion'] = CitizenQuestion::select( 'v2_profiles.nameBng as nameBng', 'v2_profiles.nameEng as nameEng', 'v2_profiles.photo as photo', 'citizen_questions.id as questionId', 'citizen_questions.citizenName as citizenName', 'citizen_questions.citizenQuestion as citizenQuestion', 'citizen_questions.mpAnswer as mpAnswer' )
        ->leftJoin( 'v2_profiles', 'v2_profiles.user_id', '=', 'citizen_questions.mp_id' )
        ->orderBy( 'citizen_questions.id', 'desc' )
        ->get();
        return view( 'frontend.single_page.citizen_all_question', $data );
    }
    public function allAnswer() {
        $data['allAnswer'] = CitizenQuestion::where( 'mpAnswer', '!=', '' )
        ->select( 'v2_profiles.nameBng as nameBng', 'v2_profiles.nameEng as nameEng', 'v2_profiles.photo as photo', 'citizen_questions.id as questionId', 'citizen_questions.citizenName as citizenName', 'citizen_questions.citizenQuestion as citizenQuestion', 'citizen_questions.mpAnswer as mpAnswer' )
        ->leftJoin( 'v2_profiles', 'v2_profiles.user_id', '=', 'citizen_questions.mp_id' )
        ->orderBy( 'citizen_questions.id', 'desc' )
        ->get();
        return view( 'frontend.single_page.citizen_all_question_answer', $data );
    }
    
    public function questionList() {
        $userId                  = authInfo()->id;
        $data['citizenQuestions'] = CitizenQuestion::where( 'mp_id', $userId )->orderBy( 'id', 'desc' )->get();

        return view( 'backend.citizen_question.index', $data );
    }

    public function questionView($id) {
        $data['viewData'] = CitizenQuestion::where( 'id', $id )->first();
        return view( 'backend.citizen_question.show', $data );
    }
    

    public function mpList( Request $request ) {

        $current_parliament_data = Parliament::where( 'status', 1 )->orderBy( 'id', 'desc' )->first();

        $parliamentNumber = $current_parliament_data->parliament_number;
        $division_id      = ( isset( $request->division_id ) && $request->division_id != '' ) ? $request->division_id : 0;
        $district_id      = ( isset( $request->district_id ) && $request->district_id != '' ) ? $request->district_id : 0;
        $upazila_id       = ( isset( $request->upazila_id ) && $request->upazila_id != '' ) ? $request->upazila_id : 0;

        $mp_id = ( isset( $request->mp_id ) && $request->mp_id != '' ) ? $request->mp_id : 0;

        $where = [];

        if ( $mp_id > 0 ) {
            $where[] = ['v2_profiles.user_id', '=', $mp_id];
        } else {
            if ( $upazila_id!='') { // 2,3,4,5
                $where[] =  [DB::raw('FIND_IN_SET('.$upazila_id.', constituencies.upazila_id)'), '>', 0];
            }
            if ( $division_id > 0 ) {
                $where[] = ['constituencies.division_id', '=', $division_id];
            }
            if ( $district_id > 0 ) {
                $where[] = ['constituencies.district_id', '=', $district_id];
            }
        }

        $profileData = V2Profile::where( 'constituencies.parliamentNumber', $parliamentNumber )
            ->where( 'v2_profiles.parliamentNumber', $parliamentNumber )
            ->where( $where )
            ->leftJoin( 'constituencies', 'constituencies.number', '=', 'v2_profiles.constituencyNumber' )
            ->select( 'v2_profiles.user_id as user_id', 'v2_profiles.nameBng as nameBng', 'v2_profiles.nameEng as nameEng', 'constituencies.number as bangladesh_number', 'constituencies.name as voterAreaEng', 'constituencies.bn_name as voterAreaBng' )
            ->get();

        return response()->json( array(
            'data' => $profileData,

        ) );
    }

    public function giveAnswer(Request $request) {
        $rules = [
            'id'   => 'required',
            'mpAnswer'   => 'required',
        ];
        $message = [
            'id.required'   => 'The id is required.',
            'mpAnswer.required'   => 'The answer field is required.',
        ];

        $validator = Validator::make( $request->all(), $rules, $message );

        if ( $validator->fails() ) {
            return response()->json( ['status' => 'rulesfail'] );

        }
        $id = $request->input('id');

        DB::beginTransaction();

        try {

            $question = CitizenQuestion::find( $id );
            $data           = $request->all();
            $result = $question->update( $data );

            if ( $result ) {
                DB::commit();
                return response()->json( ['status' => 'success', 'message' => Lang::get( 'Answer Submited Successfull' )] );
            } else {
                return response()->json( ['status' => 'error', 'message' => Lang::get( 'Answer Not Submited' )] );
            }
        } catch ( \Exception $e ) {
            DB::rollback();
            return response()->json( ['status' => 'error', 'message' => Lang::get( 'Answer Not Submited' )] );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        // dd( $request->all() );
        $rules = [
            'mp_id'           => 'required',
            'citizenName'     => 'required',
            'citizenQuestion' => 'required',
        ];
        $message = [
            'mp_id.required'           => 'The ID field is required.',
            'citizenName.required'     => 'The name field is required',
            'citizenQuestion.required' => 'The question field is required',
        ];

        $validator = Validator::make( $request->all(), $rules, $message );

        if ( $validator->fails() ) {
            return response()->json( ['status' => 'rulesfail'] );

        }

        DB::beginTransaction();

        try {

            $question = new CitizenQuestion();
            $question->fill( $request->all() );

            $result = $question->save();

            if ( $result ) {
                DB::commit();
                return response()->json( ['status' => 'success', 'message' => Lang::get( 'Question Submit Successfully' )] );
            } else {
                return response()->json( ['status' => 'error', 'message' => Lang::get( 'Question Successfully Not Submit' )] );
            }

        } catch ( \Exception $e ) {
            DB::rollback();
            return response()->json( ['status' => 'error', 'message' => Lang::get( 'Question Successfully Not Submit' )] );
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id ) {
        $data['citizenQuestion'] = CitizenQuestion::where( 'id', $id )->first();
        return view( 'frontend.single_page.citizen_question_view', $data );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id ) {
        //
    }
}
