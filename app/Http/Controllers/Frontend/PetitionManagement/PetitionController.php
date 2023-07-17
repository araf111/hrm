<?php

namespace App\Http\Controllers\Frontend\PetitionManagement;

use App\Http\Controllers\Controller;
use App\Model\Department;
use App\Model\District;
use App\Model\Division;
use App\Model\Parliament;
use App\Model\ParliamentSession;
use App\Model\Petition;
use App\Model\PetitionAttachment;
use App\Model\PetitionCommittee;
use App\Model\PetitionConsent;
use App\Model\PetitionOtp;
use App\Model\PetitionStage;
use App\Model\Profile;
use App\Model\Upazila;
use App\Model\V2Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\PostCallerClass;
use App\Http\Controllers\Backend\NotificationController;
use App\Model\Union;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class PetitionController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['divisions']    = Division::orderBy( 'name', 'asc' )->get();
        $data['districts']    = District::orderBy( 'name', 'asc' )->get();
        $data['upazilas']     = Upazila::orderBy( 'name', 'asc' )->get();
        $data['profileDatas'] = Profile::orderBy( 'id', 'asc' )->get();

        return view( 'frontend.petitionManagement.petition.form', $data );
    }

    public function mpListByDDU( Request $request ) {

        $current_parliament_data = Parliament::where( 'status', 1 )->orderBy( 'id', 'desc' )->first();

        $parliamentNumber = $current_parliament_data->parliament_number;
        $division_id      = ( isset( $request->division_id ) && $request->division_id != '' ) ? $request->division_id : 0;
        $district_id      = ( isset( $request->district_id ) && $request->district_id != '' ) ? $request->district_id : 0;
        $upazila_id       = ( isset( $request->upazila_id ) && $request->upazila_id != '' ) ? $request->upazila_id : 0;

        $where = [];

        if ( $upazila_id!='') { // 2,3,4,5
            $where[] =  [DB::raw('FIND_IN_SET('.$upazila_id.', constituencies.upazila_id)'), '>', 0];
        }
        if ( $division_id > 0 ) {
            $where[] = ['constituencies.division_id', '=', $division_id];
        }
        if ( $district_id > 0 ) {
            $where[] = ['constituencies.district_id', '=', $district_id];
        }
        $result = V2Profile::where( 'constituencies.parliamentNumber', $parliamentNumber )
        ->where( 'v2_profiles.parliamentNumber', $parliamentNumber )
        ->where( $where )
        // ->where('v2_profiles.user_id', '>', 0)
        ->leftJoin( 'constituencies', 'constituencies.number', '=', 'v2_profiles.constituencyNumber' )
        ->select( 'v2_profiles.user_id as user_id', 'v2_profiles.nameBng as nameBng', 'v2_profiles.nameEng as nameEng', 'constituencies.number as bangladesh_number', 'constituencies.name as voterAreaEng', 'constituencies.bn_name as voterAreaBng' )
        ->get();

        foreach($result as $r){
            $r->bangladesh_number = digitDateLang($r->bangladesh_number);
        }

        // dd($profileData);
        if($result){
            $profileData = $result;
        }else{
            $profileData = 0;
        }

        return response()->json( array(
            'data' => $profileData,

        ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
    }

    public function getOtpInfo( Request $request ) {
        $mobile = $request['applicant_mobile'];
        $result = PetitionOtp::where( 'mobile', $mobile )->get();
        return response()->json( array(
            'data' => $result,
        ) );
    }

    public function petitionsContactInfo( Request $request ) {
        date_default_timezone_set( "Asia/Dhaka" );
        $mobile     = $request['applicant_mobile'];
        $otp_number = random_int( 1000, 9999 );
        $start_time = date( 'Y-m-d H:i:s' );
        $end_time   = date( 'Y-m-d H:i:s', strtotime( '+2 minutes' ) );

        $otpInsertId = PetitionOtp::insertGetId( [
            'mobile'     => $mobile,
            'otp_number' => $otp_number,
            'start_time' => $start_time,
            'end_time'   => $end_time,
        ] );

        $otpData = PetitionOtp::where('id', $otpInsertId)->first();
        $otp_number = $otpData->otp_number;

        $post = new PostCallerClass(
            NotificationController::class,
            'sendSMS',
            Request::class,
            [
                'mobile_no' =>  $mobile,
                'sms_body' => "Hello Your OTP is: ".$otp_number,
            ]
        );

        $response = $post->call();

        if($response){
            return response()->json( array(
                'data' => $otp_number,
                'status' => true
    
            ) );
        }else{
            return response()->json( array(
                'data' => '',
                'status' => false
    
            ) );
        }
        
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
    }
    public function petitionInsert( Request $request ) {

        // validation
        $rules = [
            'applicant_name'        => 'required',
            'applicant_designation' => 'required',
            'applicant_nid'         => 'required',
            'applicant_mobile'      => 'required',
            'applicant_email'       => 'required',
            'applicant_division_id' => 'required',
            'applicant_district_id' => 'required',
            'applicant_upazila_id'  => 'required',
            'applicant_union'       => 'required',

            'description'           => 'required',
            'prayer'                => 'required',

            'mp_name'               => 'required',
            'otp_number'            => 'required',
            // 'attachment'            => 'mimes:doc,docx,pdf,txt|max:5048',
        ];
        $message = [
            'applicant_name.required'        => 'The Name field is required.',
            'applicant_designation.required' => 'The Designation field is required.',
            'applicant_nid.required'         => 'The NID field is required.',
            'applicant_mobile.required'      => 'The Mobile No. field is required.',
            'applicant_email.required'       => 'The E-mail field is required.',
            'applicant_division_id.required' => 'The Division field is required.',
            'applicant_district_id.required' => 'The District field is required.',
            'applicant_upazila_id.required'  => 'The Upazila field is required.',
            'applicant_union.required'       => 'The Union field is required.',

            'description.required'           => 'The Description field is required.',
            'prayer.required'                => 'The field Prayer is required.',

            'mp_name.required'               => 'The MP field is required.',
            'otp_number.required'            => 'The OTP Number field is required.',
            // 'attachment.mimes'               => 'Only Doc, Docx, PDF, TXT Files are Allowed',
        ];

        $validator = Validator::make( $request->all(), $rules, $message );

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }

        $type = $request->input( 'type' );

        $otp_number = $request->input( 'otp_number' );
        $otpInfo = PetitionOtp::where( 'mobile', $request->input( 'applicant_mobile' ) )->orderBy( 'id', 'desc' )->first();

        $petition = new Petition();

        $petition_current_committee = PetitionCommittee::where('status', 1)->first();

        try {
            if($type==1){
                $applicant_list = json_encode( $request->input( 'applicant_list' ) );
                $request['applicant_list'] = $applicant_list;
            }else{
                $request['applicant_list'] = null;
            }

            $request['committee_id'] = $petition_current_committee->id;

            $request['otp_number'] = $otp_number;
            $request['otp_id']     = $otpInfo->id;

            //echo $otpInfo->otp_number.'/'.$otp_number;

            if ( $otpInfo->otp_number == $otp_number ) {
                //dd($request->all());
                //$data = $request->all();
                $data = $request->all();
                unset($data['type']);
                // unset($data['otp_number']);
                /* $data = [];
                $data['applicant_name'] = $request->applicant_name;
                $data['applicant_designation'] = $request->applicant_designation;
                $data['applicant_nid'] = $request->applicant_nid;
                $data['applicant_mobile'] = $request->applicant_mobile;
                $data['applicant_email'] = $request->applicant_email;
                $data['applicant_division_id'] = $request->applicant_division_id;
                $data['applicant_district_id'] = $request->applicant_district_id;
                $data['applicant_upazila_id'] = $request->applicant_upazila_id;
                $data['applicant_union'] = $request->applicant_union;
                $data['applicant_more_address'] = $request->applicant_more_address;
                $data['description'] = $request->description;
                $data['prayer'] = $request->prayer;
                $data['applicant_list'] = $request->applicant_list;
                $data['mp_name'] = $request->mp_name;
                $data['otp_id'] = $otpInfo->id;
                $data['otp_number'] = $otp_number;
                $data['status'] = 0;//$request->applicant_designation;
                $data['stage_number'] = 0; //$request->applicant_designation;
                $data['rule_number'] = $request->rule_number;
                $data['submission_date'] = '';//$request->applicant_designation;
                $data['approval_date'] = ''; //$request->applicant_designation;
                $data['committee_id'] = $petition_current_committee->id;
                $data['mp_consent'] = ''; //$request->applicant_designation; */
                //dd($data);
                $result = $petition->create($data);
                //dd($result);
                //$result = $petition->save();

                $petition_id = $result->id;
                
                // dd($petition_id);

                if ( $request->hasfile( 'attachment' ) ) {

                    if ( $files = $request->file( 'attachment' ) ) {
                        foreach ( $files as $file ) {
                            $extension = $file->getClientOriginalExtension();
                            $filename  = 'petition' . '_' . time() . random_int( 0, 1000 ) . '.' . $extension; // Make a file name
                            $folder    = public_path( '/frontend/petition/' ); // Define folder path
                            $file->move( $folder, $filename ); // Upload image
                            $petitionAttachment              = new PetitionAttachment();
                            $petitionAttachment->petition_id = $petition_id;
                            $petitionAttachment->attachment  = $filename; // Set file path in database to filePath
                            $petitionAttachment->save();
                        }
                    }
                }

                if ( $result ) {
                    return 1;
                } else {
                    return 0;
                }
            }
        } catch ( \Exception $e ) {
            $errorMessage  = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            \Session::flash( 'error', $customMessage, true );
            return redirect()->back()->withInput(); //If you want to go back

        }
    }

    public function petitionOtpView( Request $request ) {
        $mobile = $request->input( 'applicant_mobile' );
        $petitionOtp = PetitionOtp::where( 'mobile', $request->input( 'applicant_mobile' ) )->orderBy( 'id', 'desc' )->first();

        $otp_number = $petitionOtp->otp_number;

        $post = new PostCallerClass(
            NotificationController::class,
            'sendSMS',
            Request::class,
            [
                'mobile_no' =>  $mobile,
                'sms_body' => "Hello Your OTP is: ".$otp_number,
            ]
        );

        $response = $post->call();

        if($response){
            $otp = 1;

        }else{
            $otp = 0;
        }
        return response()->json( array(
            'data' => $otp,

        ) );
    }

    public function petitionsWelcome() {
        return view( 'frontend.petitionManagement.petition.welcome' );
    }

    public function petitionsMonitoring() {
        return view( 'frontend.petitionManagement.petition.monitoring' );
    }

    public function petitionsMonitoringGetData( Request $request ) {

        $petition_nid    = $request->input( 'petition_nid' );
        $petition_mobile = $request->input( 'petition_mobile' );
        $otp_number = $request->input( 'otp_number' );

        $petitionOtp = PetitionOtp::where( 'mobile', $request->input( 'petition_mobile' ) )->where( 'otp_number', $otp_number )->first();

        if($petitionOtp){
            $result = Petition::where( 'applicant_nid', $petition_nid )
            ->where( 'applicant_mobile', $petition_mobile )
            ->orderBy( 'id', 'desc' )
            ->get();
        }else{
            $result = 0;
        }

        // dd($result);

        return response()->json( array(
            'data' => $result,
        ) );
    }

    public function petitionCheck(Request $request)
    {

        $applicant_nid = $request->input('petition_nid');
        $applicant_mobile = $request->input('petition_mobile');
        $otp_number = random_int(1000, 9999);
        
        $checkData = Petition::where('applicant_nid', $applicant_nid)->where('applicant_mobile', $applicant_mobile)->first();
        
        // dd($checkData);
        if($checkData){

            $updateOtp = PetitionOtp::where('id', $checkData->otp_id)->update(['otp_number' => $otp_number]);
    
            $otpData = PetitionOtp::where('id', $checkData->otp_id)->first();
            $otp_number = $otpData->otp_number;

            $post = new PostCallerClass(
                NotificationController::class,
                'sendSMS',
                Request::class,
                [
                    'mobile_no' =>  $applicant_mobile,
                    'sms_body' => "Hello Your OTP is: ".$otp_number,
                ]
            );

            $response = $post->call();
            return response()->json(array(
                'data' => $otp_number,
                'status' => true
    
            ));
        }else{

            return response()->json(array(
                'data' => '',
                'status' => false
    
            ));
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id ) {

        $data['petitions']      = Petition::where( 'id', $id )->first();
        $divisions = Division::all();
        $districts = District::all();
        $upazilas  = Upazila::all();
        $unions    = Union::all();
        $data['union']  = Union::where('id', $data['petitions']->applicant_union)->first();

        $applicant_list = $data['petitions']['applicant_list'];

        if($applicant_list !=null){
            $data['applicant_list'] = json_decode( $data['petitions']['applicant_list'] );
            $multi_name   = $data['applicant_list']->name;
            $unionId       = $data['applicant_list']->union;
            $upazilaId    = $data['applicant_list']->upazila;
            $districtId   = $data['applicant_list']->district;
            $divisionId   = $data['applicant_list']->division;
            $more_address = $data['applicant_list']->more_address;

            $unionNames    = [];
            $upazilaNames  = [];
            $districtNames = [];
            $divisionNames = [];

            foreach ( $unionId as $unionId ) {
                foreach ( $unions as $union ) {
                    if ( $union->id == $unionId ) {
                        array_push( $unionNames, $union->bn_name );
                    }
                }
            }

            foreach ( $upazilaId as $upazilaId ) {
                foreach ( $upazilas as $upazila ) {
                    if ( $upazila->id == $upazilaId ) {
                        array_push( $upazilaNames, $upazila->bn_name );
                    }
                }
            }
            foreach ( $districtId as $districtId ) {
                foreach ( $districts as $district ) {
                    if ( $district->id == $districtId ) {
                        array_push( $districtNames, $district->bn_name );
                    }
                }
            }
            foreach ( $divisionId as $divisionId ) {
                foreach ( $divisions as $division ) {
                    if ( $division->id == $divisionId ) {
                        array_push( $divisionNames, $division->bn_name );
                    }
                }
            }
            $data['allData'] = array_map( null, $multi_name, $unionNames, $upazilaNames, $districtNames, $divisionNames, $more_address );
        }


        $petition_id         = $data['petitions']->id;
        $data['attachments'] = PetitionAttachment::where( 'petition_id', $id )->get();
        
        return view( 'frontend.petitionManagement.petition.show', $data );
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

    public function petitionSystem() {
        $data['petitionSystem'] = "";
        return view( 'frontend.petitionManagement.petition_system', $data );
    }
}
