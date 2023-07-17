<?php

namespace App\Http\Controllers\Backend\ProfileActivities;

use App\Model\Designation;
use App\Traits\ProfileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Model\Profile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Model\Constituency;
use App\Model\District;
use App\Model\Division;
use App\Model\Ministry;
use App\Model\Parliament;
use App\Model\ParliamentSession;
use App\Model\V2Profile;
use Illuminate\Support\Facades\Lang;
//use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    use ProfileTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* $data['allData'] = DB::select("select * from v2_profiles order by constituencyNumber asc"); //$this->all();
        //dd($data['allData']->toArray());

        return view('backend.profileActivities.profiles.index', $data); */
        $data['current_parliament_number'] = Parliament::where('status', 1)->orderBy('id', 'desc')->first()->parliament_number;
        $data['parliament_list'] = Parliament::orderby('parliament_number', 'desc')->get();
        if (!empty($data['parliament_list'])) {
            foreach ($data['parliament_list'] as $d) {
                $d->parliament_number_bn = \Lang::get($d->parliament_number);
            }
        }
        return view('backend.profileActivities.profiles.index_new', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['designations'] = Designation::all();
        $data['profileID_list'] = [10490, 10473, 11428, 11433, 11431, 9432, 9430, 9442, 11437, 11444, 9449, 11443, 9451, 9453, 9452, 11442, 9450, 9437, 9435, 9436, 11440, 9434, 9447, 9445, 11439, 11451, 11450, 11449, 9455, 9439, 9456, 11448, 9443, 9454, 9440, 9444, 9446, 11447, 11446, 9469, 9466, 9462, 11445, 9441, 10428, 11438, 11436, 9460, 9457, 11435, 9473, 9470, 11432, 9467, 9464, 4526, 11430, 11441, 11429, 10489, 10488, 10487, 10486, 10485, 10484, 10483, 10439, 10482, 10481, 10437, 10436, 10438, 10480, 10434, 10479, 10478, 10431, 10430, 10477, 10429, 10476, 10441, 10443, 10475, 10442, 10474, 10440, 10472, 10432, 10471, 10470, 10469, 10468, 10467, 10466, 10465, 10464, 10462, 10463, 10460, 10459, 10458, 10457, 10454, 10456, 10453, 10452, 10451, 10450, 10449, 10448, 10435, 10433, 10447, 10446, 10445, 5396, 5395, 5394, 5393, 5392, 5391, 9448, 9433, 9458, 9461, 9477, 9463, 9465, 9468, 9459, 9472, 9475, 9474, 9476, 9478, 9438, 9471, 6428, 4569, 4568, 4567, 4572, 4571, 4570, 4566, 4565, 4564, 4563, 4562, 4561, 4560, 4559, 4558, 4557, 4556, 4555, 4554, 4553, 4552, 4551, 4550, 4549, 4548, 4547, 4485, 4484, 4546, 4545, 4544, 4483, 4543, 4482, 4481, 4480, 4479, 4542, 4541, 4478, 4477, 4476, 4475, 4474, 4473, 4540, 4539, 4538, 4537, 4536, 4535, 4534, 4533, 4532, 4530, 4531, 4529, 4528, 4527, 4525, 4524, 4523, 4522, 4521, 4520, 4519, 4518, 4517, 4516, 4515, 4514, 4513, 4512, 4511, 4510, 4509, 4508, 4507, 4506, 4505, 4504, 4503, 4502, 4501, 4500, 4499, 4498, 4467, 4466, 4468, 4465, 4464, 4463, 4462, 4461, 4460, 4459, 4455, 4456, 4497, 4457, 4458, 4496, 4495, 4494, 4493, 4492, 4491, 4490, 4489, 4488, 4472, 4471, 4470, 4487, 4486, 4449, 4448, 4447, 4446, 4445, 4444, 4443, 4469, 4442, 4441, 4440, 4439, 4438, 4437, 4436, 4435, 4434, 4433, 4432, 4431, 4454, 4430, 4453, 4451, 4452, 4450, 4429, 4428, 4427, 4425, 4426, 4419, 4418, 4424, 4417, 4416, 4415, 4414, 4413, 4412, 4423, 4411, 4422, 4421, 4420, 4400, 4410, 4399, 4398, 4409, 4408, 4407, 4406, 4405, 4404, 4397, 4396, 4395, 4394, 4393, 4401, 4392, 4403, 4391, 4402, 4390, 4389, 4388, 4382, 4381, 4387, 4380, 4379, 4378, 4386, 4377, 4376, 4375, 4385, 4374, 4384, 4373, 4383, 10461, 10474];
        return view('backend.profileActivities.profiles.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mpProfile = $this->creationProfile($request);

        if ($mpProfile['status'] == true) {
            return redirect()->back()->with('success', 'Successfully created');
        } else {
            //dd($mpProfile['message']);
            //return redirect()->back()->withInput();
            return redirect()->back()->withInput();
            //return redirect()->back()->with('error', $mpProfile['message']);
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
        $data['editData'] = $this->getProfile($id);
        // dd($data['editData']->toARray());
        $data['profileID_list'] = [10490, 10473, 11428, 11433, 11431, 9432, 9430, 9442, 11437, 11444, 9449, 11443, 9451, 9453, 9452, 11442, 9450, 9437, 9435, 9436, 11440, 9434, 9447, 9445, 11439, 11451, 11450, 11449, 9455, 9439, 9456, 11448, 9443, 9454, 9440, 9444, 9446, 11447, 11446, 9469, 9466, 9462, 11445, 9441, 10428, 11438, 11436, 9460, 9457, 11435, 9473, 9470, 11432, 9467, 9464, 4526, 11430, 11441, 11429, 10489, 10488, 10487, 10486, 10485, 10484, 10483, 10439, 10482, 10481, 10437, 10436, 10438, 10480, 10434, 10479, 10478, 10431, 10430, 10477, 10429, 10476, 10441, 10443, 10475, 10442, 10474, 10440, 10472, 10432, 10471, 10470, 10469, 10468, 10467, 10466, 10465, 10464, 10462, 10463, 10460, 10459, 10458, 10457, 10454, 10456, 10453, 10452, 10451, 10450, 10449, 10448, 10435, 10433, 10447, 10446, 10445, 5396, 5395, 5394, 5393, 5392, 5391, 9448, 9433, 9458, 9461, 9477, 9463, 9465, 9468, 9459, 9472, 9475, 9474, 9476, 9478, 9438, 9471, 6428, 4569, 4568, 4567, 4572, 4571, 4570, 4566, 4565, 4564, 4563, 4562, 4561, 4560, 4559, 4558, 4557, 4556, 4555, 4554, 4553, 4552, 4551, 4550, 4549, 4548, 4547, 4485, 4484, 4546, 4545, 4544, 4483, 4543, 4482, 4481, 4480, 4479, 4542, 4541, 4478, 4477, 4476, 4475, 4474, 4473, 4540, 4539, 4538, 4537, 4536, 4535, 4534, 4533, 4532, 4530, 4531, 4529, 4528, 4527, 4525, 4524, 4523, 4522, 4521, 4520, 4519, 4518, 4517, 4516, 4515, 4514, 4513, 4512, 4511, 4510, 4509, 4508, 4507, 4506, 4505, 4504, 4503, 4502, 4501, 4500, 4499, 4498, 4467, 4466, 4468, 4465, 4464, 4463, 4462, 4461, 4460, 4459, 4455, 4456, 4497, 4457, 4458, 4496, 4495, 4494, 4493, 4492, 4491, 4490, 4489, 4488, 4472, 4471, 4470, 4487, 4486, 4449, 4448, 4447, 4446, 4445, 4444, 4443, 4469, 4442, 4441, 4440, 4439, 4438, 4437, 4436, 4435, 4434, 4433, 4432, 4431, 4454, 4430, 4453, 4451, 4452, 4450, 4429, 4428, 4427, 4425, 4426, 4419, 4418, 4424, 4417, 4416, 4415, 4414, 4413, 4412, 4423, 4411, 4422, 4421, 4420, 4400, 4410, 4399, 4398, 4409, 4408, 4407, 4406, 4405, 4404, 4397, 4396, 4395, 4394, 4393, 4401, 4392, 4403, 4391, 4402, 4390, 4389, 4388, 4382, 4381, 4387, 4380, 4379, 4378, 4386, 4377, 4376, 4375, 4385, 4374, 4384, 4373, 4383, 10461, 10474];
        return view('backend.profileActivities.profiles.create', $data);
    }

    public function profileDetails(Request $request, $type)
    {
        $id = $request->id;
        if ($type == 'view') {
        } else if ($type == 'edit') {
            $data['parliament_list'] = Parliament::where('status', 1)->orderBy('id', 'desc')->get();
            $data['session_list'] = ParliamentSession::where('status', 1)->orderBy('id', 'desc')->get();
            $data['ministry_list'] = Ministry::where('status', 1)->orderBy('id', 'asc')->get();
            $data['designation_list'] = Designation::all();
            $data['constituency_list'] = Constituency::orderBy('number', 'asc')->get();
            $data['district_list'] = District::where('status', 1)->orderBy('id', 'desc')->get();
            $data['division_list'] = Division::where('status', 1)->orderBy('id', 'desc')->get();
            $data['religion_list'] = array(
                array('id' => 1, 'name' => Lang::get('Islam')),
                array('id' => 2, 'name' => Lang::get('Hindu')),
                array('id' => 3, 'name' => Lang::get('Buddhist')),
                array('id' => 3, 'name' => Lang::get('Christian'))
            );
            $data['status_list'] = array(
                array('id' => 1, 'name' => Lang::get('Pending')),
                array('id' => 2, 'name' => Lang::get('Approved')),
                array('id' => 3, 'name' => Lang::get('Rejected'))
            );
            $data['political_party_list'] = DB::select("select * from political_parties where status=1");
        }

        $data['profileData'] = Profile::where('profiles.id', $id)
            ->where('profiles.status', 1)
            ->leftJoin('parliaments', 'profiles.parliament_id', '=', 'parliaments.id')
            ->leftJoin('ministries', 'profiles.ministry_id', '=', 'ministries.id')
            ->leftJoin('designations', 'profiles.designation_id', '=', 'designations.id')
            ->leftJoin('political_parties', 'profiles.political_parties_id', '=', 'political_parties.id')
            ->leftJoin('constituencies', 'profiles.constituency_id', '=', 'constituencies.id')
            ->leftJoin('districts', 'profiles.birth_district_id', '=', 'districts.id')
            ->leftJoin('divisions', 'districts.division_id', '=', 'divisions.id')
            ->select('profiles.*', 'ministries.name_bn as ministry_name', 'parliaments.parliament_number', 'designations.name_bn as designation_name', 'political_parties.name_bn as political_party_name', 'constituencies.bn_name as voter_area', 'constituencies.number as bangladesh_number', 'districts.bn_name as district_name', 'divisions.bn_name as division_name')
            ->first();

        if (!empty($data['profileData'])) {
            $data['profileData']->religion = (int)$data['profileData']->religion;
            $data['profileData']->status = (int)$data['profileData']->status;
            $data['profileData']->religion_text = $this->myReligion($data['profileData']->religion);
            $data['profileData']->status_text = $this->myStatus($data['profileData']->status);
            if (isApi()) {
                $response['status'] = 'success';
                $response['message'] = '';
                $response['api_info']    = $data;
                return response()->json($response);
            }
        } else {
            if (isApi()) {
                $response['status'] = 'error';
                $response['message'] = 'Data not Found';
                return response()->json($response);
            }
        }
    }

    private function myReligion($id)
    {
        if ($id == 1) {
            return Lang::get('Islam');
        } else if ($id == 2) {
            return Lang::get('Hindu');
        } else if ($id == 3) {
            return Lang::get('Buddhist');
        } else if ($id == 4) {
            return Lang::get('Christian');
        } else {
            return '';
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
        $id = $request->id;
        $mpProfile = $this->creationProfile($request, $id);

        if ($mpProfile['status'] == true) {
            if (isApi()) {
                $response['status'] = 'success';
                $response['message'] = 'Profile Successfully updated';
                return response()->json($response);
            }
        } else {
            if (isApi()) {
                $response['status'] = 'error';
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
    public function update(Request $request, $id)
    {
        $mpProfile = $this->creationProfile($request, $id);

        if ($mpProfile['status'] == true) {
            return redirect()->back()->with('success', 'Successfully updated');
        } else {
            dd($mpProfile['message']);
            return redirect()->back()->with('error', $mpProfile['message']);
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
            $response['status'] = 'success';
            $response['message'] = '';
            $response['api_info']    = $list;
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
            $response['status'] = 'success';
            $response['message'] = '';
            $response['api_info']    = $list;
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
            $response['status'] = 'success';
            $response['message'] = '';
            $response['api_info']    = $data;
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
        $prp_token = "bTEWXWO3orST9NVJuZjyQhe7Zumq1riigPnkBGtjfHcUSaH3qRBcm9qA3ZPMDCQp0Ueybso1siKnzOKkzN6X1kJ0cBU6eEgj3B7kvJaw60kqMAwIzvRZ5";
        $endpoint = "https://prp.parliament.gov.bd/ext/employee-records-api";
        //$client = new \GuzzleHttp\Client;
        if ($request->profile_by == 'employee_id') {
            $action = "getEmployeeRecordById";
            $empId = $request->empId;
            $response = Http::withHeaders([
                'token' => $prp_token,
            ])->get($endpoint, [
                'action' => $action,
                'empId' => $empId,
            ]);
        } else if ($request->profile_by == 'constituency_number') {
            // list of profile with the given constituency number
        }

        $statusCode = $response->getStatusCode();
        $content = $response->getBody();

        if ($statusCode == 200) {
            //process the data
            //$all_info = json_decode($content,true);
            //$basic_info = $all_info['payload']['employeeBasicInformationModel'];
            /* 
            "nameEng" => "MR.KAZI KERAMAT ALI"
            "nameBng" => "কাজী কেরামত আলী"
            "fatherNameEng" => "KAZI HEDAYET HOSSAIN"
            "fatherNameBng" => ""
            "motherNameEng" => "MONAKKA BEGUM"
            "motherNameBng" => ""
            "spouseNameEng" => "/"
            "spouseNameBng" => "/"
            "dateOfBirth" => "22-04-1954"
            "presentAddressEng" => "Building No- 4, Flat No- 304, Parliament Member Building, Nakhal Para, Tejgaon, Dhaka. Dhaka Division, Dhaka,Dhaka North City Corporation"
            "presentAddressBng" => "ভবন নং-০৪, ফ্ল্যাট নং-৩০৪, সংসদ-সদস্য ভবন,নাখালপাড়া, তেজগাঁও, ঢাকা। ঢাকা বিভাগ, ঢাকা,ঢাকা উত্তর সিটি কর্পোরেশন"
            "permanentAddressEng" => "Hospital Road, Sajjankanda, Post Dhaka Division, Rajbari, Rajbari Sadar,Rajbari Paurashava"
            "permanentAddressBng" => "হাসপাতাল রোড, সজ্জনকান্দা, ডাকঘর-রাজবাড়ী-৭৭০০ ঢাকা বিভাগ, রাজবাড়ী, রাজবাড়ী সদর,রাজবাড়ী পৌরসভা"
            "nidNumber" => "8227604113844"
            "birthCertificateNumber" => ""
            "passportNumber" => ""
            "passportIssueDate" => "01-01-0001"
            "passportExpireDate" => "01-01-0001"
            "gender" => "Male"
            "religion" => "Islam"
            "bloodGroup" => ""
            "identificationMark" => ""
            "height" => 0.0
            "personalMobile" => "8801715564484"
            "alternativeMobile" => ""
            "email" => "rajbari.1@parliament.gov.bd"
            "employmentCategory" => ""
            "freedomFighterInfo" => ""
            "officePhoneNumber" => ""
            "officePhoneExtension" => ""
            "faxNumber" => "",
            "photo" => [],
            "isMP" => 1
            "professionOfMP" => "ব্যবসা"
            "addressOfMP" => "ভবন নং-০৪, ফ্ল্যাট নং-৩০৪, সংসদ-সদস্য ভবন,নাখালপাড়া, তেজগাঁও, ঢাকা।"
            */
            /* $data = array(
                'name_bn' => $basic_info['nameBng'],
                'name_eng' => $basic_info['nameEng'],
                'father_name' => $basic_info['fatherNameEng'],
                'mother_name' => $basic_info['motherNameEng'],
                'spouse_name_eng' => $basic_info['spouseNameEng'],
                'spouse_name_bn' => $basic_info['spouseNameBng'],
                //'dateOfBirth' => $basic_info['dateOfBirth'],
                'spouse_name_bn' => $basic_info['spouseNameBng'],
                'residential_address' => $basic_info['presentAddressEng'],
                //'presentAddressBng' => $basic_info['presentAddressBng'],
                'parmanent_address' => $basic_info['permanentAddressEng'],
                //'permanentAddressBng' => $basic_info['permanentAddressBng'],
                'parmanent_address' => $basic_info['permanentAddressEng'],
                'nid_no' => $basic_info['nidNumber'],
            );
            dd($data); */
            //dd($all_info['payload']['employeeBasicInformationModel']);
        }

        return $content;

        /* 
            need numeric values for the following items from PRP
            religion
            division
            district
            political party
            isMP = ?(mp, speaker,minister etc... need ID of those designation)
            Married/UnMarried = how do PRP check it?
        */
    }

    public function updateV2Profile(Request $request){
        dd($request->all());
        $profileID = $request->profileID;

        $data = array(
            'nameEng' => $request->nameEng,
            'nameBng' => $request->nameBng
        );

        $done = V2Profile::where('profileID',$profileID)->update($data);
        if($done){
            echo 'successfully updated';
        }

    }

    public function loadAllProfiles()
    {
        $test = '';
        $cons_data = json_decode($test,true);

        $real_prp = '';
        //$emp_data = json_decode($real_prp, true);
        foreach ($cons_data as $d) {
            $result[] = array(
                'name' => $d['constituency_name_en'],
                'bn_name' => $d['constituency_name_bn'],
                'number' => $d['constituency_number'],
                'status' => 1,
                'upazila_id' =>1,
                'district_id' =>1,
                'division_id' =>1
            );
        }
        $done = DB::table('constituencies')->insert($result);
        if($done){
            echo 'ok done';
        }
        //echo json_encode($result, true);
    }
}
