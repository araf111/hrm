<?php

namespace App\Http\Controllers\Backend\ProfileActivities;

use App\Http\Controllers\Controller;
use App\Model\Constituency;
use App\Model\Designation;
use App\Model\District;
use App\Model\Division;
use App\Model\Ministry;
use App\Model\Parliament;
use App\Model\ParliamentSession;
use App\Model\V2Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Lang;
use PDF;
use App\Http\PostCallerClass;
use App\Http\Controllers\Backend\NotificationController;

set_time_limit(0);
class V2ProfileController extends Controller
{
    //use V2ProfileTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$data['allData'] = V2Profile::orderBy('constituencyNumber', 'asc')->get(); 
        $data['current_parliament_number'] = Parliament::where('status', 1)->orderBy('id', 'desc')->first()->parliament_number;
        $data['parliament_list'] = Parliament::orderby('parliament_number', 'desc')->get();
        if (!empty($data['parliament_list'])) {
            foreach ($data['parliament_list'] as $d) {
                $d->parliament_number_bn = \Lang::get($d->parliament_number);
            }
        }
        return view('backend.profileActivities.profiles.index_new', $data);
    }

    public function getAllProfile(Request $request)
    {
        if ($request->token == 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9tcHBvcnRhbC5uYW5vaXQuYml6XC9hcGlcL2F1dGhcL2xvZ2luIiwiaWF0IjoxNjI3OTg4NDIwLCJleHAiOjE2Mjc5OTU2MjAsIm5iZiI6MTYyNzk4ODQyMCwianRpIjoiQXZ3NUc4Q0d1akZhc0hOWiIsInN1YiI6NDgsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.5gndv-DctKCr2FlT2SrWSu43bIRJLXCPDC33O3YyQdI') {
            $data['allData']      = V2Profile::orderBy('constituencyNumber', 'asc')->get();
            $response['status']   = 'success';
            $response['message']  = '';
            $response['api_info'] = $data;
            return response()->json($response);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Token Mismatch']);
        }
        //return view('backend.profileActivities.profiles.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['designations']   = Designation::all();
        $data['profileID_list'] = V2Profile::orderBy('constituencyNumber', 'asc')->pluck('profileID');
        $data['parliament_list'] = Parliament::orderby('parliament_number', 'desc')->get();
        if (!empty($data['parliament_list'])) {
            foreach ($data['parliament_list'] as $d) {
                $d->parliament_number_bn = \Lang::get($d->parliament_number);
            }
        }
        $data['bloodgroup_list'] = bloodGroupList();
        return view('backend.profileActivities.profiles.create_v2', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->profileID == '' || $request->nameBng == '' || $request->nameEng == '') {
            $error_message = [];
            if ($request->profileID == '') {
                $error_message[] = \Lang::get('ProfileID is Required');
            }
            if ($request->nameBng == '') {
                $error_message[] = \Lang::get('Bangla Name is Required');
            }
            if ($request->nameEng == '') {
                $error_message[] = \Lang::get('English Name is Required');
            }
            return json_encode(array('status' => false, 'message' => $error_message));
        }
        $existing_data = V2Profile::where('profileID', $request->profileID)->first();
        if (!empty($existing_data)) {
            return json_encode(array('status' => false, 'message' => ['Profile exists']));
        } else {
            $current_parliament_data = Parliament::orderBy('parliament_number', 'desc')->first();
            $request['parliamentNumber'] = $current_parliament_data->parliament_number;
            $done = V2Profile::insert($request->all());
            if ($done) {
                return json_encode(array('status' => true));
            } else {
                return json_encode(array('status' => false, 'message' => ['Error during data saving...']));
            }
        }

        /* $mpProfile = $this->creationProfile($request);

    if ($mpProfile['status'] == true) {
    return redirect()->back()->with('success', 'Successfully created');
    } else {
    return redirect()->back()->withInput();
    } */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['profileData'] = V2Profile::where('v2_profiles.profileID', $id)
            ->where('v2_profiles.status', 1)
            ->leftJoin('parliaments', 'v2_profiles.parliamentNumber', '=', 'parliaments.id')
            ->leftJoin('designations', 'v2_profiles.designation_id', '=', 'designations.id')
            ->leftJoin('political_parties', 'v2_profiles.political_parties_id', '=', 'political_parties.id')
            ->leftJoin('constituencies', 'v2_profiles.constituencyNumber', '=', 'constituencies.number')
            ->select('v2_profiles.*', 'parliaments.parliament_number', 'designations.name_bn as designation_name', 'political_parties.name_bn as political_party_name', 'constituencies.bn_name as voter_area', 'constituencies.number as bangladesh_number')
            ->first();

        if (!empty($data['profileData'])) {
            $data['profileData']->religion      = (int) $data['profileData']->religion;
            $data['profileData']->status        = (int) $data['profileData']->status;
            $data['profileData']->religion_text = $this->myReligion($data['profileData']->religion);
            $data['profileData']->status_text   = $this->myStatus($data['profileData']->status);
            $data['profileData']->photo         = (isset($data['profileData']->photo) && $data['profileData']->photo != '') ? arrayToimage($data['profileData']->photo) : '';
            $data['profileData']->bloodGroup_text = $this->myBloodGroup($data['profileData']->bloodGroup);
            if (isApi()) {
                $response['status']   = 'success';
                $response['message']  = '';
                $response['api_info'] = $data;
                return response()->json($response);
            }
        } else {
            if (isApi()) {
                $response['status']  = 'error';
                $response['message'] = 'Data not Found';
                return response()->json($response);
            }
            return redirect()->back()->with('error', 'No Data Found');
        }
        //dd($data['profileData']);
        return view('backend.profileActivities.profiles.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data['editData']       = V2Profile::where('profileID', $id)->first();
        $data['profileID_list'] = V2Profile::orderBy('constituencyNumber', 'asc')->pluck('profileID');
        $data['parliament_list'] = Parliament::orderby('parliament_number', 'desc')->get();
        if (!empty($data['parliament_list'])) {
            foreach ($data['parliament_list'] as $d) {
                $d->parliament_number_bn = \Lang::get($d->parliament_number);
            }
        }
        $data['bloodgroup_list'] = bloodGroupList();
        return view('backend.profileActivities.profiles.create_v2', $data);
    }

    public function myProfile()
    {
        if (isset(authInfo()->profileData) && isset(authInfo()->profileData['profileID'])) {
            $data['profileID']       = authInfo()->profileData['profileID'];
            return view('backend.profileActivities.profiles.myprofile', $data);
        } else {
            //echo '<h2>in progress .....</h2>';
            $data['profileID']       = authInfo()->id; // for non-MP user
            return view('backend.user-management.user-info.myprofile', $data);
        }
    }

    public function commonDataList()
    {
        $data['constituency_list'] = Constituency::orderBy('number', 'asc')->get();
        $data['division_list']     = Division::where('status', 1)->orderBy('id', 'desc')->get();
        $data['district_list']     = District::where('status', 1)->orderBy('id', 'desc')->get();

        if (isApi()) {
            $response['status']   = 'success';
            $response['message']  = '';
            $response['api_info'] = $data;
            return response()->json($response);
        }

        return response()->json($data);
    }

    public function profileDetails(Request $request, $type)
    {
        $id = $request->id;
        if ($type == 'view') {
        } else if ($type == 'edit') {
            $data['ministry_list']     = Ministry::where('status', 1)->orderBy('id', 'asc')->get();
            $data['session_list']      = ParliamentSession::where('status', 1)->orderBy('id', 'desc')->get();
            $data['designation_list']  = Designation::all();
            $data['parliament_list']   = Parliament::orderBy('id', 'desc')->get();
            
            $data['political_party_list'] = DB::select("select * from political_parties where status=1");
            $data['bloodgroup_list'] = bloodGroupList();
            $data['religion_list']     = array(
                array('id' => 1, 'name' => Lang::get('Islam')),
                array('id' => 2, 'name' => Lang::get('Hindu')),
                array('id' => 3, 'name' => Lang::get('Christian')),
                array('id' => 4, 'name' => Lang::get('Buddhist')),
                array('id' => 5, 'name' => Lang::get('Atheism')),
                array('id' => 6, 'name' => Lang::get('Others')),
            );
            $data['status_list'] = array(
                array('id' => 1, 'name' => Lang::get('Pending')),
                array('id' => 2, 'name' => Lang::get('Approved')),
                array('id' => 3, 'name' => Lang::get('Rejected')),
            );
        } else if ($type == 'info') {
        }

        $data['profileData'] = V2Profile::where('v2_profiles.profileID', $id)
            ->where('v2_profiles.status', 1)
            ->leftJoin('parliaments', 'v2_profiles.parliamentNumber', '=', 'parliaments.id')
            // ->leftJoin('ministries', 'profiles.ministry_id', '=', 'ministries.id')
            ->leftJoin('designations', 'v2_profiles.designation_id', '=', 'designations.id')
            ->leftJoin('political_parties', 'v2_profiles.political_parties_id', '=', 'political_parties.id')
            ->leftJoin('constituencies', 'v2_profiles.constituencyNumber', '=', 'constituencies.number')
            ->leftJoin('districts', 'constituencies.district_id', '=', 'districts.id')
            ->leftJoin('divisions', 'districts.division_id', '=', 'divisions.id')
            ->select('v2_profiles.*', 'parliaments.parliament_number', 'designations.name_bn as designation_name', 'political_parties.name as party_name_en','political_parties.name_bn as party_name_bn', 'constituencies.bn_name as voter_area', 'constituencies.number as bangladesh_number', 'divisions.bn_name as division_name_bn', 'divisions.name as division_name_en', 'districts.bn_name as district_name_bn', 'districts.name as district_name_bn')
            ->first();

        if (!empty($data['profileData'])) {
            $data['profileData']->religion      = (int) $data['profileData']->religion;
            $data['profileData']->status        = (int) $data['profileData']->status;
            $data['profileData']->religion_text = $this->myReligion($data['profileData']->religion);
            $data['profileData']->status_text   = $this->myStatus($data['profileData']->status);
            if (isApi()) {
                $data['profileData']->photo         =  $data['profileData']->photo;
            } else {
                $data['profileData']->photo         = (isset($data['profileData']->photo) && $data['profileData']->photo != '') ? arrayToimage($data['profileData']->photo) : '';
            }
            $data['profileData']->bloodGroup_text = $this->myBloodGroup($data['profileData']->bloodGroup);
            if (isApi()) {
                $response['status']   = 'success';
                $response['message']  = '';
                $response['api_info'] = $data;
                return response()->json($response);
            }
            if ($type == 'view') {
                return view('backend.profileActivities.profiles.partial.show', $data);
            }
            if ($type == 'info') {
                return json_encode(array('status' => true, 'data' => $data['profileData']), true);
            }
            if ($type == 'edit') {
                $data['editData']       = V2Profile::where('profileID', $id)->first();

                //include user info from user table
                $userInfo = User::where('id', $data['editData']->user_id)->first();
                $data['userInfo'] = (!empty($userInfo)) ? $userInfo : '';
                return view('backend.profileActivities.profiles.partial.edit', $data);
            }
        } else {
            if (isApi()) {
                $response['status']  = 'error';
                $response['message'] = 'Data not Found';
                return response()->json($response);
            }
            if ($type == 'info') {
                return json_encode(array('status' => false, 'data' => []), true);
            }
            return \Lang::get("No Data Found");
        }
    }

    private function myReligion($id)
    {
        if ($id == 1) {
            return Lang::get('Islam');
        } else if ($id == 2) {
            return Lang::get('Hindu');
        } else if ($id == 3) {
            return Lang::get('Christian');
        } else if ($id == 4) {
            return Lang::get('Buddhist');
        } else if ($id == 5) {
            return Lang::get('Aheism');
        } else {
            return Lang::get('Others');
        }
    }
    private function myBloodGroup($id)
    {
        $blood_group_list = bloodGroupList();
        if (session()->get('language') == 'bn') {
            return $blood_group_list[$id]['name_bng'];
        } else {
            return $blood_group_list[$id]['name_eng'];
        }
    }
    private function myStatus($id)
    {
        if ($id == 1) {
            return Lang::get('Pending');
        } else if ($id == 2) {
            return Lang::get('Approved');
        } else if ($id == 3) {
            return Lang::get('Rejected');
        } else {
            return '';
        }
    }

    public function updateProfile(Request $request)
    {
        $id        = $request->id;
        $mpProfile = $this->creationProfile($request, $id);

        if ($mpProfile['status'] == true) {
            if (isApi()) {
                $response['status']  = 'success';
                $response['message'] = 'Profile Successfully updated';
                return response()->json($response);
            }
        } else {
            if (isApi()) {
                $response['status']  = 'error';
                $response['message'] = 'Data Not Updated';
                return response()->json($response);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateData(Request $request)
    {
        
        //dd($request->all());
        //$request->except(['token']);
        $existing_photo = "";

        $data = $request->all();
        $data['dateOfBirth'] = (isset($data['dateOfBirth']) && $data['dateOfBirth']!='')? date('Y-m-d',strtotime($data['dateOfBirth'])):'';
        $data['passportIssueDate'] = (isset($data['passportIssueDate']) && $data['passportIssueDate']!='')? date('Y-m-d',strtotime($data['passportIssueDate'])):'';
        $data['passportExpireDate'] = (isset($data['passportExpireDate']) && $data['passportExpireDate']!='')? date('Y-m-d',strtotime($data['passportExpireDate'])):'';
        /* if (isset($data['token'])) {
            unset($data['token']);
            unset($data['id']);
            unset($data['district_name_bn']);
        } */
        if ($request->hasfile('photo')) {
            $profile_photo = V2Profile::where('profileID', $request->profileID)->first();
            if (!empty($profile_photo) && $profile_photo->photo != '') {
                $existing_photo = $profile_photo->photo;
            }

            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename  = time() . random_int(0, 1000) . '.' . $extension; // Make a file name
            $folder    = public_path('/backend/profile/'); // Define folder path
            $file->move($folder, $filename); // Upload image
            $data['photo'] = $filename;
        }

        /////
        $update_data = [];
        $table_columns = ["nameEng", "nameBng", "fatherNameEng", "fatherNameBng", "motherNameEng", "motherNameBng", "spouseNameEng", "spouseNameBng", "dateOfBirth", "presentAddressEng", "presentAddressBng", "permanentAddressEng", "permanentAddressBng", "nidNumber", "birthCertificateNumber", "passportNumber", "passportIssueDate", "passportExpireDate", "gender", "religion", "bloodGroup", "identificationMark", "height", "personalMobile", "alternativeMobile", "email", "freedomFighterInfo", "officePhoneNumber", "officePhoneExtension", "faxNumber", "photo","isMP", "professionOfMP", "addressOfMP", "constituencyNumber", "parliamentNumber", "designation_id", "political_parties_id", "ministry_id", "spouse_nid_no", "office_address", "birth_district_id", "merital_status", "status"];
        foreach ($data as $k => $v) {
            //echo $k.'='.$v;
            if (!in_array($k, $table_columns)) {
                unset($data[$k]);
            }
        }

        $done = V2Profile::where('profileID', $request->profileID)->update($data);
        if ($done) {
            $folder = public_path('/backend/profile/');
            @unlink($folder . $existing_photo);

            //update photo column in user table...***

            if (isApi()) {
                $response['status']  = 'success';
                $response['message'] = 'Profile Successfully updated';
                return response()->json($response);
            }
            return json_encode(array('status' => true));
        } else {
            if (isApi()) {
                $response['status']  = 'error';
                $response['message'] = 'Data Not Updated';
                return response()->json($response);
            }
            return json_encode(array('status' => false));
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
        //
    }

    public function listOfConstituency()
    {
        $list = Constituency::orderBy('number', 'asc')->get();

        if (isApi()) {
            $response['status']   = 'success';
            $response['message']  = '';
            $response['api_info'] = $list;
            return response()->json($response);
        }

        if (count($list) > 0) {
            return json_encode(array('status' => true, 'data' => $list), true);
        } else {
            return json_encode(array('status' => false), true);
        }
    }
    public function listOfDesignation()
    {
        $list = Designation::orderBy('id', 'asc')->get();

        if (isApi()) {
            $response['status']   = 'success';
            $response['message']  = '';
            $response['api_info'] = $list;
            return response()->json($response);
        }

        if (count($list) > 0) {
            return json_encode(array('status' => true, 'data' => $list), true);
        } else {
            return json_encode(array('status' => false), true);
        }
    }

    public function listOfProfile(Request $request)
    {

        $where = [];
        if ($request->constituency_id) {
            $where[] = ['constituency_id', '=', $request->constituency_id];
        }
        if ($request->designation_id) {
            $where[] = ['designation_id', '=', $request->designation_id];
        }
        if ($request->official_phone) {
            $where[] = ['official_phone', '=', $request->official_phone];
        }
        if ($request->profile_id) {
            $where[] = ['user_id', '=', $request->profile_id];
        }

        $data['profile_list'] = Profile::where($where)->get();

        if (isApi()) {
            $response['status']   = 'success';
            $response['message']  = '';
            $response['api_info'] = $data;
            return response()->json($response);
        }

        if (count($data['profile_list']) > 0) {
            return json_encode(array('status' => true, 'data' => $data), true);
        } else {
            return json_encode(array('status' => false), true);
        }
    }

    public function loadProfile(Request $request)
    {
        // Load Profile recrod from PRP Software
        $prp_login_details = prpLogin();
        if($prp_login_details==200){
            $prp_secret = \Session::get('prpSecret');
            $endpoint  = "https://prp.parliament.gov.bd/ext/employee-records-api";
            if ($request->profile_by == 'employee_id') {
                $action   = "getEmployeeRecordById";
                $empId    = $request->empId;
                $response = Http::withHeaders($prp_secret)->get($endpoint, [
                    'action' => $action,
                    'empId'  => $empId,
                ]);
            } else if ($request->profile_by == 'non_mp') {
                // list of staff/employee with department
                $action   = "getEmployeeRecordById";
                $empId    = $request->empId;
                $response = Http::withHeaders($prp_secret)->get($endpoint, [
                    'action' => $action,
                    'empId'  => $empId,
                ]); 
            }

            $statusCode = $response->getStatusCode();
            $content    = $response->getBody();
            $decoded_content = json_decode($content,true);
            if(isset($decoded_content['payload']['employeeBasicInformationModel'])){
                $decoded_content['payload']['employeeBasicInformationModel']['nameEng'] = ucwords(strtolower($decoded_content['payload']['employeeBasicInformationModel']['nameEng']));
            }
            //return $content;
            return json_encode($decoded_content,true);
        }
        else if($prp_login_details==401){
            //echo 'PRP server down';
        }
        
    }

    public function loadAllProfiles()
    {
        /* $test      = '';
        $cons_data = json_decode( $test, true );

        $real_prp = '';
        //$emp_data = json_decode($real_prp, true);
        foreach ( $cons_data as $d ) {
        $result[] = array(
        'name'        => $d['constituency_name_en'],
        'bn_name'     => $d['constituency_name_bn'],
        'number'      => $d['constituency_number'],
        'status'      => 1,
        'upazila_id'  => 1,
        'district_id' => 1,
        'division_id' => 1,
        );
        }
        $done = DB::table( 'constituencies' )->insert( $result );
        if ( $done ) {
        echo 'ok done';
        }
        //echo json_encode($result, true); */

        /* $test      = '';
        $cons_data = json_decode( $test, true );
        //dd($cons_data);
        $real_prp = '';
        //$emp_data = json_decode($real_prp, true);
        foreach ( $cons_data['payload'] as $d ) {
        if(isset($d['photo'])){
        $data = implode('', array_map(function ($e) {
        return pack("C*", $e);
        }, $d['photo']));

        $data = base64_decode($data);
        $img = imagecreatefromstring($data);
        ob_start();
        imagepng($img);
        $png = ob_get_clean();
        $uri = "data:image/png;base64," . base64_encode($png);

        $result= array(
        'profileID'        => $d['empRecordId'],
        'photo'     => $uri
        );
        $done = DB::table( 'v2_profiles' )->where('profileID',$d['empRecordId'])->update($result);
        if($done){
        echo 'done '.PHP_EOL;
        }
        }

        } */

        /* if ( $done ) {
    echo 'ok done';
    } */
    }

    public function generateDoc(Request $request, $all = null)
    {
        if (!is_null($all)) {
            //list of all MPs
            $doc_type               = $request->doctype;

            $current_parliament_data = Parliament::where('status', 1)->orderBy('id', 'desc')->first();

            $parliamentNumber = (isset($request->parliamentNumber) && $request->parliamentNumber != '') ? $request->parliamentNumber : $current_parliament_data->parliament_number;
            $bangladesh_number = (isset($request->bd_no) && $request->bd_no != '') ? $request->bd_no : 0;
            $division_id = (isset($request->division_id) && $request->division_id != '') ? $request->division_id : 0;
            $district_id = (isset($request->district_id) && $request->district_id != '') ? $request->district_id : 0;
            $constituency_id = (isset($request->constituency_id) && $request->constituency_id != '') ? $request->constituency_id : 0;
            $where = [];
            //$where[] = ['v2_profiles.parliamentNumber', '=', $parliamentNumber];
            if ($bangladesh_number > 0) {
                $where[] = ['constituencies.number', '=', $bangladesh_number];
            } else {
                if ($constituency_id > 0) {
                    $where[] = ['constituencies.id', '=', $constituency_id];
                }
                if ($division_id > 0) {
                    $where[] = ['constituencies.division_id', '=', $division_id];
                }
                if ($district_id > 0) {
                    $where[] = ['constituencies.district_id', '=', $district_id];
                }
            }

            $profile_list = V2Profile::where('constituencies.parliamentNumber', $parliamentNumber)
                ->leftJoin('constituencies', 'constituencies.number', '=', 'v2_profiles.constituencyNumber')
                ->leftJoin('political_parties', 'political_parties.id', '=', 'v2_profiles.political_parties_id')
                ->where('v2_profiles.parliamentNumber', $parliamentNumber)
                ->where($where)
                ->select('v2_profiles.*', 'constituencies.number as bangladesh_number', 'constituencies.name as voter_area_eng', 'constituencies.bn_name as voter_area_bng','political_parties.name as party_name_en','political_parties.name_bn as party_name_bn')
                ->orderBy('constituencyNumber', 'asc')->get();

            $final_result = '<table id="list_mp_table" class="table table-sm table-bordered table-striped" style="width:100%;"> <thead> <tr><th align="left">' . \Lang::get("Serial") . '</th><th align="left">' . \Lang::get("Name") . '</th><th align="left">' . \Lang::get("Bangladesh No.") . '</th><th align="left">' . \Lang::get("Constituency") . '</th> <th align="left">' . \Lang::get("Phone") . '</th></tr></thead><tbody>';
            if (count($profile_list) > 0) {
                $sn = 1;
                foreach ($profile_list as $p) {
                    if (session()->get('language') == 'bn') {
                        $p->mp_name = $p->nameBng;
                        $p->voter_area = $p->voter_area_bng;
                    } else {
                        $p->mp_name = $p->nameEng;
                        $p->voter_area = $p->voter_area_bng;
                    }

                    $action_for_admin = '<a href="' . route("admin.profile-activities.v2profiles.edit", $p->profileID) . '"class="btn btn-sm btn-info" target="_blank"><i class="fa fa-edit"></i></a> <a href="' . route("admin.profile-activities.v2profiles.show", $p->profileID) . '"
                    class="btn btn-sm btn-success" target="_blank"><i class="fa fa-eye"></i></a> <button type="button" class="btn btn-info" onClick=load_report("pdf","' . $p->profileID . '")><i class="fa fa-file-pdf"> </i></button>';
                    $action_for_non_admin = '<a href="' . route("admin.profile-activities.v2profiles.show", $p->profileID) . '" class="btn btn-sm btn-success" target="_blank"><i class="fa fa-eye"></i></a> <button type="button" class="btn btn-info" onClick=load_report("pdf","' . $p->profileID . '")><i class="fa fa-file-pdf"> </i></button>';

                    $action_line = (authInfo()->usertype == 'admin') ? $action_for_admin : $action_for_non_admin;

                    $final_result .= '<tr><td>' . digitDateLang($sn++) . '</td><td><img src="' . asset('/public/backend/profile/' . $p->photo) . '" class="ml-2 img-circle elevation-2" alt="" style="width: 35px; vertical-align: middle; border-style: none; border-radius: 50% !important; box-shadow: 0 3px 6px rgba(0,0,0,.16),0 3px 6px rgba(0,0,0,.23)!important;"> ' . $p->mp_name . '</td><td>' . digitDateLang($p->bangladesh_number) . '</td><td>' . $p->voter_area . '</td><td>' . digitDateLang($p->personalMobile) . '</td></tr>';
                }
            }
            $final_result .= '</tbody></table>';


            $template_name          = 'profile';
            $data['profile_list'] = $final_result;

            if ($doc_type === 'pdf') {
                $data['common_header'] = \Lang::get('Bangladesh National Parliament');
                $data['page_header']   = \Lang::get('MP Profile');
                $pdf                   = PDF::loadView('report.pdf.' . $template_name, $data);
                $pdfString             = $pdf->Output('', 'S');
                $pdfBase64             = base64_encode($pdfString);
                return 'data:application/pdf;base64,' . $pdfBase64;
            } else if ($doc_type === 'doc') {
                $data['common_header'] = \Lang::get('Bangladesh National Parliament');
                $data['page_header']   = \Lang::get('MP Profile');
            }
        } else {
            $doc_type               = $request->doctype;
            $profile_id             = $request->profile_id;
            $template_name          = 'profile';
            $data['profileDetails'] = V2Profile::where('profileID', $profile_id)->first();
            if(!empty($data['profileDetails'])){
                $data['profileDetails']->religion_text = $this->myReligion($data['profileDetails']->religion);
                $data['profileDetails']->bloodGroup_text = $this->myBloodGroup($data['profileDetails']->bloodGroup);
            }

            if ($doc_type === 'pdf') {
                $data['common_header'] = \Lang::get('Bangladesh National Parliament');
                $data['page_header']   = \Lang::get('MP Profile');
                $pdf                   = PDF::loadView('report.pdf.' . $template_name, $data);
                $pdfString             = $pdf->Output('', 'S');
                $pdfBase64             = base64_encode($pdfString);
                return 'data:application/pdf;base64,' . $pdfBase64;
            } else if ($doc_type === 'doc') {
                $data['common_header'] = \Lang::get('Bangladesh National Parliament');
                $data['page_header']   = \Lang::get('MP Profile');
            }
        }
    }

    public function crossCheck()
    {
        /* $json_list = file_get_contents('D:\MP Portal Docs\AllMpRelatedData\allMpList.json');
        $list = V2Profile::orderBy('constituencyNumber', 'asc')->get();
        //dd(json_decode($json_list,true));
        $counting = 1;
        $json_list = json_decode($json_list, true);
        foreach ($list as $p) {
            foreach ($json_list as $j) {
                if ($p->profileID == $j['profileId']) {
                    //$p->profileID = $j['profileId'];
                    $done = V2Profile::where('profileID', $p->profileID)->update(
                        array(
                            'fatherNameEng' => $j['fatherNameEng'],
                            'fatherNameBng' => $j['fatherNameBng'],
                            'motherNameEng' => $j['motherNameEng'],
                            'motherNameBng' => $j['motherNameBng'],
                            'presentAddressEng' => $j['presentAddressEng'],
                            'presentAddressBng' => $j['presentAddressBng'],
                            'permanentAddressEng' => $j['permanentAddressEng'],
                            'permanentAddressBng' => (isset($j['permanentAddressBng']))?$j['permanentAddressBng']:'',
                            'gender' => $j['gender'],
                            'religion' => $j['religion'] - 1,
                            'bloodGroup' => $j['bloodGroup'],
                            'email' => $j['email'],
                            'political_parties_id' => $j['politicalParty']
                        )
                    );
                    if ($done) {
                        $counting++;
                    }
                    //$p->pk_id = $j['id'];
                }
            }
        }
        echo $counting; */

        /* $json_list = file_get_contents('D:\MP Portal Docs\AllMpRelatedData\electionConstituency.json');
        $json_list = json_decode($json_list, true);
        foreach ($json_list as $p) {
            $data[] = array(
                'parliamentNumber'=>$p['parliamentNumber'],
                'name'=>$p['constituency_name_en'],
                'bn_name'=>$p['constituency_name_bn'],
                'number'=>$p['constituency_number'],
                'status'=>1,
                'upazila_id'=>1,
                'district_id'=>1,
                'division_id'=>1
            );
        }
       $done = DB::table('constituencies')->insert($data);
        if($done){
            echo 'success';
        } */
    }

    public function imageConversion()
    {
        /* $list = V2Profile::orderBy('constituencyNumber', 'asc')->get();
        $counting = 1;
        foreach ($list as $p) {
            if ($p->photo != '') {
                $file_name = $p->id . 'p' . time() . '.jpg';
                $photo_location = public_path('/backend/profile/' . $file_name);
                $this->base64_to_jpeg($p->photo, $photo_location);
                $done = DB::table('v2_profiles')->where('profileID', $p->profileID)->update(array('photo' => $file_name));

                if ($done) {
                    $counting += 1;
                }
            }
        }
        echo $counting; */
    }

    private function base64_to_jpeg($base64_string, $output_file)
    {
        // open the output file for writing
        $ifp = fopen($output_file, 'wb');

        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode(',', $base64_string);

        // we could add validation here with ensuring count( $data ) > 1
        fwrite($ifp, base64_decode($data[1]));

        // clean up the file resource
        fclose($ifp);

        return $output_file;
    }

    public function testSMS(){

        /* $random = array();
        for ($i = 0; $i <= 30; $i++) {
            $random[$i] = rand(1,30);
        }

        for($i=0; $i<count($random); $i++){
            $selected_date = $this->randomDate('2021-09-15', '2021-09-30');
            $data = [
                'parliament_session_id' =>3,
                'date' => $selected_date,
                'ministry_id'=> $random[$i]
            ];
    
            $poripotro = DB::table('circulars')->insert($data);
        } */
        
        

        // $post = new PostCallerClass(
        //     NotificationController::class,
        //     'sendSMS',
        //     Request::class,
        //     [
        //         'mobile_no' => '01878042517',
        //         'sms_body' => 'Hello world.... localhost'
        //     ]
        // );
        // $response = $post->call();
    }

    // Find a randomDate between $start_date and $end_date
    function randomDate($start_date, $end_date)
    {
        // Convert to timetamps
        $min = strtotime($start_date);
        $max = strtotime($end_date);

        // Generate random number using above bounds
        $val = rand($min, $max);

        // Convert back to desired date format
        return date('Y-m-d', $val);
    }
}
