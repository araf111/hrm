<?php

namespace App\Http\Controllers\Backend\UserManagement;

use App\Http\Controllers\Controller;
use App\Model\Department;
use App\Model\Parliament;
use App\Model\Role;
use App\Model\UserRole;
use App\User;
use App\Model\V2Profile;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function list()
    {
        $data['users'] = User::with(['user_role' => function ($q) {
            $q->with(['role_details']);
        }])->where('id', '!=', 1)->get();

        return view('backend.user-management.user-info.list', $data);
    }

    public function add()
    {
        $data['roles']           = Role::where('id', '!=', 1)->orderBy('sort', 'asc')->get();
        $data['department_list'] = Department::where('status', 1)->orderBy('id', 'asc')->get();
        $data['user_type_list']  = userTypeList();
        $data['parliaments']     = Parliament::orderBy('id', 'asc')->get();
        // dd('hii');
        return view('backend.user-management.user-info.add', $data);
    }

    public function getProfileList(Request $request, $type)
    {
        $list = $request->list;
        $parliament_number =  $request->parliament_number;
        if ($type == 'mp') {
            $profile_list = V2Profile::where('parliamentNumber', $parliament_number)
                ->orderBy('constituencyNumber', 'asc')->pluck('profileID');
            if ($list == 'dropdown') {
                $output = "";
                if (isset($profile_list) && count($profile_list) > 0) {
                    $output = '<option value="">' . \Lang::get('Select ProfileID') . '</option>';
                    foreach ($profile_list as $p) {
                        $output .= '<option value="' . $p . '">' . digitDateLang($p) . '</option>';
                    }
                } else {
                    $output = '<option value="">' . __('No Data Available') . '</option>';
                }
                return $output;
            } else {
                return json_encode($profile_list, true);
            }
        } else {
            $profile_list = User::where('profileID', '<>', '')->orderBy('id', 'asc')->pluck('profileID')->toArray();
            $prp_emp_list = [2110005, 1120001, 2110018, 2320002, 1110004, 2110095, 1110074, 1110075, 2210116, 1110072, 1110073, 1110049, 1110107, 1110034, 1111110, 1110097, 1110098, 1110089, 2110116, 1110112, 2110109, 2110108, 2110107, 2310379, 2110098, 2110087, 2110097, 2110115, 1110100, 2110103, 2110099, 2110100, 2110112, 2110102, 2110106, 2110114, 2110113, 2110105, 2110111, 2110110, 2110081, 2110080, 2110093, 2110092, 2110091, 2110090, 1110096, 2310385, 2310368, 2310436, 2310403, 2310374, 2310384, 2310365, 2310421, 1110095, 1110080, 2310424, 2310413, 2310419, 2310363, 2310402, 2310382, 2310387, 2310432, 2310414, 2310415, 2310369, 2310381, 2310386, 2310392, 2310377, 2310366, 2310367, 2310430, 2310396, 2310375, 1110099, 1110032, 2310380, 2310362, 2310364, 2310383, 2310390, 2310431, 2310361, 2310433, 2310370, 2310371, 2310378, 2310388, 2310376, 2310360, 2310435, 2310411, 2310391, 2310437, 1110082, 2310434, 2310410, 2310425, 2310420, 2310401, 2310389, 2310398, 2310423, 2110088, 1110094, 2110089, 2310372, 2310418, 2310400, 2310406, 2310427, 2310408, 2310416, 2310426, 2310407, 2310412, 2310397, 2310409, 2310417, 2310356, 2310359, 2310399, 2310395, 2310394, 2310393, 2310358, 1110085, 1110053, 1110079, 1110090, 1110077, 1110081, 1110084, 1110071, 1110083, 1110066, 2210115, 2110079, 2110085, 1110070, 2110006, 2110086, 2110077, 1110086, 2110083, 2110084, 2110082, 2210083, 2110078, 1110065, 2410032, 2110021, 2310154, 1110062, 1110063, 1110061, 1110060, 1110045, 1110016, 1110059, 1110031, 2110023, 2310025, 2110066, 2410119, 2310077, 2110069, 2310068, 1110018, 2410141, 2410046, 1110030, 2110073, 2210003, 2110065, 2210007, 2110071, 2110070, 2110072, 2110075, 2110068, 2110074, 2110067, 2110076, 2110015, 2310033, 1110002, 1110058, 1110025, 2110063, 2410220, 2310027, 2310131, 2310210, 2310284, 1310012, 2410095, 2410019, 2410025, 1310015, 2110049, 1310014, 1310013, 1310011, 2210114, 2210112, 2210113, 2410096, 1110057, 2210111, 2310233, 2410205, 2410203, 1110011, 2410155, 2310137, 2310147, 2410003, 2310251, 2410034, 2410021, 2310008, 2410184, 2210040, 2310211, 2410036, 2410031, 2310209, 2310252, 2210067, 2110017, 2410078, 2410144, 2410117, 2410145, 2410018, 2310138, 2310344, 2310343, 2310156, 2310102, 2310016, 2310157, 2310045, 2310213, 2310303, 2410045, 2410035, 2210041, 2310115, 2310297, 2410076, 2310238, 2410143, 2310150, 2410060, 2310014, 2310237, 2210076, 2310125, 2210052, 2310262, 2410093, 2410028, 2310259, 2410208, 2310308, 2110003, 2410162, 2310236, 2410098, 2310035, 2410042, 2310294, 2210057, 2310094, 2410150, 2410109, 2410157, 2410186, 2410014, 2410026, 2410116, 2410061, 2410062, 2110053, 2410006, 2310060, 2310253, 2310309, 2310240, 2310307, 2210031, 2410065, 2310352, 2410172, 2210056, 2310306, 2410215, 2110013, 2410052, 2310278, 2310159, 2410048, 2310246, 2410023, 2410066, 2310087, 2310208, 1110043, 2410071, 2310289, 2410083, 2410055, 2410139, 2410059, 2210069, 1110037, 1110039, 1110042, 1110038, 1110036, 1110041, 2210077, 2310281, 2210001, 1310003, 1310004, 2410146, 1310007, 2210063, 2310317, 1310010, 2410069, 2310355, 2310121, 2310207, 1110035, 1110040, 2310204, 2410237, 2310267, 2110034, 1310008, 1310006, 1310001, 1310005, 2310232, 1310002, 2310227, 2410081, 2410213, 2310286, 2310277, 2310028, 2310104, 2310272, 2310347, 2310217, 2310258, 2310226, 2310043, 2310337, 2310139, 2210032, 2310225, 2410238, 2310091, 2310220, 2310283, 2410072, 2310218, 2310036, 2310216, 2310274, 2310044, 2310282, 2310001, 2310346, 2310050, 2310280, 2310224, 2410013, 2310338, 2410015, 2210098, 2210018, 2410008, 2410068, 2310215, 2310212, 2310273, 2310230, 2210051, 2310203, 2410050, 2310214, 2310205, 2410017, 2310206, 2310229, 2310221, 2410038, 2310353, 2410114, 2310219, 2310285, 2310271, 2410221, 2310196, 2310268, 2310228, 2310223, 2110020, 2310276, 2310029, 2210082, 2310269, 2310231, 2310103, 2110016, 2110045, 2210091, 2210044, 2310140, 2210073, 2410005, 2310270, 2310279, 2410058, 2310275, 2310124, 2310295, 2310108, 2310263, 2310290, 2410113, 2210038, 2310013, 2110052, 2410115, 2110008, 2310298, 2110012, 2110011, 2310296, 2410112, 2310241, 2310100, 2410110, 2110048, 1110056, 2410111, 1110051, 2410030, 2410073, 2310292, 2310130, 2310089, 2210089, 2110026, 2310182, 2310291, 2210024, 2310105, 2210043, 2310093, 2310113, 2310195, 2410101, 2310244, 2310245, 2310247, 2310250, 2310248, 2410092, 2310145, 2310329, 1110054, 2310325, 2310243, 2310249, 2310189, 2310266, 2210068, 2410044, 2310260, 2310339, 2310110, 2310261, 2310194, 2310184, 2310239, 2310234, 2310342, 2310305, 2410051, 2310293, 2310287, 2310304, 2310255, 2310254, 2310256, 2310067, 2310171, 2310313, 2310257, 2310059, 2310331, 2310310, 2310191, 2310202, 2310333, 2310200, 2310199, 2310197, 2310193, 2310188, 2310175, 2310187, 2310178, 2310316, 2310335, 2310324, 2310332, 2310328, 2310054, 2310265, 2310302, 2410016, 2310235, 2310300, 2310301, 2310299, 2310312, 2310322, 2310334, 2310320, 2310319, 2310326, 2310336, 2310314, 2210105, 2110046, 2410086, 2410039, 2310327, 2210054, 2310311, 2310042, 2310063, 2310323, 2310315, 2310341, 2310177, 2310288, 2310198, 2310354, 2310345, 2310155, 2310350, 2310173, 2310201, 2310183, 2310169, 2410118, 2310330, 2310321, 2310318, 2210106, 2310129, 2310066, 2310176, 2210103, 2310179, 2310126, 2310142, 2310351, 2410218, 2310349, 2310062, 2310090, 2410154, 2410011, 2410084, 2410212, 2410137, 2410070, 2410188, 2410152, 2210081, 2410089, 2310017, 2410087, 2410214, 2410185, 2410166, 2410198, 2410135, 2410165, 2210029, 2310170, 2310172, 2310340, 2310186, 2310348, 2310084, 2110044, 2110004, 2410169, 2410067, 2410156, 2410027, 2410053, 2410136, 2410088, 2310153, 2310046, 2310020, 2310048, 2210045, 2310166, 2210070, 2410057, 2310264, 2310127, 2410216, 2410217, 2310015, 2210049, 2310162, 2310009, 2410192, 2210037, 2310122, 2410183, 2410158, 2310168, 2310030, 2410002, 2310190, 2210066, 2410210, 2410209, 2310141, 2410204, 2410024, 2410147, 2110036, 2210101, 2310107, 2410206, 2210065, 2310073, 2310101, 2410211, 2210027, 2210058, 2310116, 2210030, 2310117, 2210026, 2410190, 2210074, 2410151, 2410164, 2110038, 2410138, 2410100, 2410159, 2310118, 2210100, 2210006, 2410077, 2210033, 2310069, 2210010, 2410202, 2410161, 2110037, 2440029, 2410043, 2110035, 2210085, 2310095, 2210009, 2310167, 2210036, 2210020, 2210061, 2210060, 2410191, 2210016, 2210084, 2410064, 2410219, 2410189, 2110042, 2410094, 2410082, 2410010, 2410001, 2410029, 2410079, 2410149, 2410167, 2410054, 2410142, 2410201, 2310052, 2410187, 2410140, 2410056, 2210079, 2310012, 2210002, 2410199, 2210072, 2210023, 2210078, 2210017, 2310136, 2410148, 2310074, 2410207, 2410160, 2410153, 2310120, 2310161, 2310088, 2310149, 2310056, 2310092, 2310106, 2310085, 2310098, 2310152, 2310181, 2310151, 2310097, 2310123, 2210053, 2310037, 2210028, 2410080, 2110029, 2410049, 2210104, 2210025, 2410091, 2310081, 2310134, 2210012, 2310026, 2210021, 2210011, 2210110, 2210047, 2210071, 2310119, 2410012, 2210108, 2210064, 2310112, 2110051, 2310055, 2110031, 2110032, 2210102, 2110033, 2110041, 2410090, 2410004, 2310164, 2310039, 1110009, 2310018, 2210039, 2210004, 2110009, 2110001, 2310163, 2410163, 2210097, 2210090, 2310148, 2210019, 2210005, 2210059, 2210035, 2210109, 1110012, 1110013, 1110024, 1110019, 1110050, 1110005, 2110043, 2410022, 2410171, 2410040, 2410075, 2410170, 2410009, 2410041, 2410063, 2410168, 2410047, 2210107, 2310078, 2310132, 2310111, 2310165, 2110014, 2310086, 2110025, 2110061, 2310109, 2110062, 2310023, 2310058, 2310180, 2310158, 2310049, 2310003, 2310024, 2310133, 2310047, 2310083, 2310041, 2310021, 2310031, 2310080, 2310061, 2310005, 2310114, 2310004, 2310022, 2310065, 2310174, 2310072, 2310079, 2310019, 2310160, 2310064, 2310071, 2310144, 2310051, 2310143, 2310096, 2310146, 2310002, 2310011, 2310135, 2310057, 2310034, 2310010, 2310006, 2310038, 2310128, 2310099, 2310032, 2310040, 2310070, 2210034, 2210075, 2210087, 2210015, 2210050, 2210092, 2210096, 2210048, 2210086, 2210095, 2210046, 2210094, 2210055, 2210093, 2210008, 2210099, 2110060, 2110056, 2110027, 2110040, 2110024, 2110054, 2110007, 2110002, 2210088, 2210013, 2210022, 2110019, 2110010, 2110047, 2110022, 2110028, 2110050, 2410178, 2410020, 2410033, 2410235, 2410234, 2410233, 2410232, 2410231, 2410230, 2410229, 2410228, 2410227, 2410226, 2410224, 2410222, 2410223, 2410197, 2410196, 2410195, 2410194, 2410193, 2410180, 2410182, 2410179, 2410177, 2410176, 2410175, 2410174, 2410173, 2410130, 2410134, 2410133, 2410132, 2410131, 2410129, 2410127, 2410128, 2410126, 2410125, 2410122, 2410123, 2410124, 2410121, 2410120, 2410108, 2410107, 2410106, 2410104, 2410105, 2410102, 2410103, 2310076, 2310075, 1110001, 2110030, 2410236, 2410181, 2410225, 2312141, 1110047, 2310222, 1110022, 2210062, 2312140, 1110055, 2210080, 1110021, 2310576, 2210117, 2210118, 2110101, 3350001, 2220001, 3150002, 2340001, 3310001, 2210014, 1220001, 2320001, 3320001, 3140001, 2320002, 3210001, 2210042, 1320001, 1210001, 2340002, 3210002, 2110005, 1210002, 3150003, 2110039, 2110055, 2110057, 2110058, 2110059, 2110064, 2110094, 2110096, 2110101, 1110003, 2210119];
            $profile_list = array_merge($profile_list, $prp_emp_list);
            if ($list == 'dropdown') {
                $output = "";
                if (isset($profile_list) && count($profile_list) > 0) {
                    $output = '<option value="">' . \Lang::get('Select ProfileID') . '</option>';
                    foreach ($profile_list as $p) {
                        $output .= '<option value="' . $p . '">' . digitDateLang($p) . '</option>';
                    }
                } else {
                    $output = '<option value="">' . __('No Data Available') . '</option>';
                }
                return $output;
            } else {
                return json_encode($profile_list, true);
            }
        }
    }

    public function store(Request $request)
    {
        /* $this->validate($request, [
            'email' => 'required|unique:users,email',
            //'profileID' => 'required',
        ]); */
        $rules = [
            'name' => 'required',
            'name_bn' => 'required',
            'usertype' => 'required'
        ];
        $message = [
            'email.unique'             => \Lang::get('The email field shoud be unique'),
            'email.required'           => \Lang::get('This field is required.'),
            //'profileID.required'     => 'ProfileID is required.',
            'name.required' => \Lang::get('This field is required.'),
            'name_bn.required'     => \Lang::get('This field is required.'),
            'usertype.required'     => \Lang::get('This field is required.')
        ];

        if ($request->hasfile('photo')) {
            $allowed_extension = ['jpg', 'jpeg', 'png', 'gif'];
            if ($file = $request->file('photo')) {
                $extension = $file->getClientOriginalExtension();
                $file_size = $file->getSize();
                if (!in_array($extension, $allowed_extension)) {
                    $rules['photo'] = 'nullable|mimes:jpg,jpeg,png,gif|max:5048';
                    $message['photo.*'] = \Lang::get('jpg,jpeg,png,gif Files are Allowed');
                }
            }
        }


        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return json_encode(array('status' => false, 'message' => $validator->getMessageBag()->toArray()), true);
        }

        $myFile = "";

        if ($request->hasfile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename  = time() . random_int(0, 1000) . '.' . $extension; // Make a file name
            $folder    = public_path('/backend/user/'); // Define folder path
            $file->move($folder, $filename); // Upload image
            //$data['photo'] = $filename;
            $myFile = $filename;
        }
        if (isset($request->profileID) && $request->profileID != '') {
            //check if this profileid exist in usres table
            $existing_profile = User::where('profileID', $request->profileID)->first();
            if (!empty($existing_profile)) {
                return back()->with('error', 'Profile already Exist');
            } else {
                DB::beginTransaction();
                try {
                    //$data                = new User();
                    if ($request->usertype == 'mp' || $request->usertype == 'speaker') {
                        //check if this profileid exist in profile table(for MP)
                        //if not exist then return error message
                        //else update v2_profile table with user_id(users.id)
                        $existing_mp = V2Profile::where('profileID', $request->profileID)->first();
                        if (empty($existing_mp)) {
                            return back()->with('error', 'No Profile Found');
                        } else {
                            $data                = new User();
                            $data->profileID    = $request->profileID;
                            $data->name          = $request->name;
                            $data->name_bn       = $request->name_bn;
                            $data->email         = $request->email;
                            $data->password      = bcrypt($request->password);
                            $data->usertype      = $request->usertype;
                            $data->department_id = $request->department_id;
                            $data->mobile_no     = $request->mobile_no;
                            $data->designation   = $request->designation;
                            $data->photo = $myFile;
                            $data->save();
                            //after save .. just update v2_profile table with user_id(users.id)
                            DB::table('v2_profiles')->where(array('profileID' => $existing_mp->profileID))->update(array('user_id' => $data->id));
                        }
                    } else {
                        $data                = new User();
                        $data->profileID    = $request->profileID;
                        $data->name          = $request->name;
                        $data->name_bn       = $request->name_bn;
                        $data->email         = $request->email;
                        $data->password      = bcrypt($request->password);
                        $data->usertype      = $request->usertype;
                        $data->department_id = $request->department_id;
                        $data->mobile_no     = $request->mobile_no;
                        $data->designation   = $request->designation;
                        $data->photo = $myFile;
                        $data->save();
                    }

                    if ($data->id) {
                        foreach ($request->user_role as $role) {
                            $user_rule          = new UserRole();
                            $user_rule->user_id = $data->id;
                            $user_rule->role_id = $role;
                            $user_rule->save();
                        }
                    }
                    DB::commit();
                    if ($request->ajax()) {
                        return json_encode(array('status' => true, 'message' => \Lang::get('Data Saved successfully')), true);
                    }
                    return redirect()->route('admin.user-management.user-info.list', ['id' => $data->id])->with('success', \Lang::get('Data Not Saved'));
                } catch (\Exception $e) {
                    //dd($e);
                    DB::rollback();
                    if ($request->ajax()) {
                        return json_encode(array('status' => false, 'message' => \Lang::get('Data Not Saved')), true);
                    }
                    return redirect()->back()->with('error', 'Error occured');
                }
            }
        } else {
            DB::beginTransaction();
            try {
                $data                = new User();
                $data->profileID    = $request->profileID;
                $data->name          = $request->name;
                $data->name_bn       = $request->name_bn;
                $data->email         = $request->email;
                $data->password      = bcrypt($request->password);
                $data->usertype      = $request->usertype;
                $data->department_id = $request->department_id;
                $data->mobile_no     = $request->mobile_no;
                $data->designation   = $request->designation;
                $data->photo = $myFile;

                $data->save();

                DB::commit();
                if ($request->ajax()) {
                    return json_encode(array('status' => true, 'message' => \Lang::get('Data Saved successfully')), true);
                }
                return redirect()->route('admin.user-management.user-info.list', ['id' => $data->id])->with('success', \Lang::get('Data Not Saved'));
            } catch (\Exception $e) {
                //dd($e);
                DB::rollback();
                if ($request->ajax()) {
                    return json_encode(array('status' => false, 'message' => \Lang::get('Data Not Saved')), true);
                }
                return redirect()->back()->with('error', 'Error occured');
            }
        }
    }

    public function edit($id)
    {
        $data['editData']        = User::find($id);
        $data['role_array']      = UserRole::where('user_id', $id)->get()->toArray();
        $data['roles']           = Role::where('id', '!=', 1)->orderBy('sort', 'asc')->get();
        $data['department_list'] = Department::where('status', 1)->orderBy('id', 'asc')->get();
        $data['user_type_list']  = userTypeList();
        $data['parliaments']     = Parliament::orderBy('id', 'asc')->get();

        $data['profileID_list'] = [10490, 10473, 11428, 11433, 11431, 9432, 9430, 9442, 11437, 11444, 9449, 11443, 9451, 9453, 9452, 11442, 9450, 9437, 9435, 9436, 11440, 9434, 9447, 9445, 11439, 11451, 11450, 11449, 9455, 9439, 9456, 11448, 9443, 9454, 9440, 9444, 9446, 11447, 11446, 9469, 9466, 9462, 11445, 9441, 10428, 11438, 11436, 9460, 9457, 11435, 9473, 9470, 11432, 9467, 9464, 4526, 11430, 11441, 11429, 10489, 10488, 10487, 10486, 10485, 10484, 10483, 10439, 10482, 10481, 10437, 10436, 10438, 10480, 10434, 10479, 10478, 10431, 10430, 10477, 10429, 10476, 10441, 10443, 10475, 10442, 10474, 10440, 10472, 10432, 10471, 10470, 10469, 10468, 10467, 10466, 10465, 10464, 10462, 10463, 10460, 10459, 10458, 10457, 10454, 10456, 10453, 10452, 10451, 10450, 10449, 10448, 10435, 10433, 10447, 10446, 10445, 5396, 5395, 5394, 5393, 5392, 5391, 9448, 9433, 9458, 9461, 9477, 9463, 9465, 9468, 9459, 9472, 9475, 9474, 9476, 9478, 9438, 9471, 6428, 4569, 4568, 4567, 4572, 4571, 4570, 4566, 4565, 4564, 4563, 4562, 4561, 4560, 4559, 4558, 4557, 4556, 4555, 4554, 4553, 4552, 4551, 4550, 4549, 4548, 4547, 4485, 4484, 4546, 4545, 4544, 4483, 4543, 4482, 4481, 4480, 4479, 4542, 4541, 4478, 4477, 4476, 4475, 4474, 4473, 4540, 4539, 4538, 4537, 4536, 4535, 4534, 4533, 4532, 4530, 4531, 4529, 4528, 4527, 4525, 4524, 4523, 4522, 4521, 4520, 4519, 4518, 4517, 4516, 4515, 4514, 4513, 4512, 4511, 4510, 4509, 4508, 4507, 4506, 4505, 4504, 4503, 4502, 4501, 4500, 4499, 4498, 4467, 4466, 4468, 4465, 4464, 4463, 4462, 4461, 4460, 4459, 4455, 4456, 4497, 4457, 4458, 4496, 4495, 4494, 4493, 4492, 4491, 4490, 4489, 4488, 4472, 4471, 4470, 4487, 4486, 4449, 4448, 4447, 4446, 4445, 4444, 4443, 4469, 4442, 4441, 4440, 4439, 4438, 4437, 4436, 4435, 4434, 4433, 4432, 4431, 4454, 4430, 4453, 4451, 4452, 4450, 4429, 4428, 4427, 4425, 4426, 4419, 4418, 4424, 4417, 4416, 4415, 4414, 4413, 4412, 4423, 4411, 4422, 4421, 4420, 4400, 4410, 4399, 4398, 4409, 4408, 4407, 4406, 4405, 4404, 4397, 4396, 4395, 4394, 4393, 4401, 4392, 4403, 4391, 4402, 4390, 4389, 4388, 4382, 4381, 4387, 4380, 4379, 4378, 4386, 4377, 4376, 4375, 4385, 4374, 4384, 4373, 4383, 10461, 10474];
        return view('backend.user-management.user-info.add', $data);
    }

    public function update(Request $request, $id)
    {

        $rules = [
            'name' => 'required',
            'name_bn' => 'required',
            'usertype' => 'required'
        ];
        $message = [
            'email.unique'             => \Lang::get('The email field shoud be unique'),
            'email.required'           => \Lang::get('This field is required.'),
            //'profileID.required'     => 'ProfileID is required.',
            'name.required' => \Lang::get('This field is required.'),
            'name_bn.required'     => \Lang::get('This field is required.'),
            'usertype.required'     => \Lang::get('This field is required.')
        ];

        $user_info = User::where('email', $request->email)->where('id', '!=', $id)->first();
        if (!empty($user_info)) {
            $rules['email'] = 'required|unique:users,email';
            //$rules['profileID'] = 'required|unique:users,profileID';
        } else {
            $rules['email'] = 'required';
            //$rules['profileID'] = 'required';
        }

        if ($request->hasfile('photo')) {
            $allowed_extension = ['jpg', 'jpeg', 'png', 'gif'];
            if ($file = $request->file('photo')) {
                $extension = $file->getClientOriginalExtension();
                $file_size = $file->getSize();
                if (!in_array($extension, $allowed_extension)) {
                    $rules['photo'] = 'nullable|mimes:jpg,jpeg,png,gif|max:5048';
                    $message['photo.*'] = \Lang::get('jpg,jpeg,png,gif Files are Allowed');
                }
            }
        }


        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return json_encode(array('status' => false, 'message' => $validator->getMessageBag()->toArray()), true);
        }

        $existing_photo = "";
        $myFile = "";

        if ($request->hasfile('photo')) {
            $profile_photo = User::find($id);
            if (!empty($profile_photo) && $profile_photo->photo != '') {
                $existing_photo = $profile_photo->photo;
            }

            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename  = time() . random_int(0, 1000) . '.' . $extension; // Make a file name
            $folder    = public_path('/backend/user/'); // Define folder path
            $file->move($folder, $filename); // Upload image
            //$data['photo'] = $filename;
            $myFile = $filename;
        }

        DB::beginTransaction();
        try {
            $data          = User::find($id);
            if ($myFile != '') {
                $data->photo = $myFile;
            }
            $data->name    = $request->name;
            $data->profileID    = $request->profileID;
            $data->name_bn = $request->name_bn;
            $data->email   = $request->email;
            if ($request->password != '' || $request->password != null) {
                $data->password = bcrypt($request->password);
            }
            $data->usertype      = $request->usertype;
            $data->department_id = $request->department_id;
            $data->mobile_no     = $request->mobile_no;
            $data->designation   = $request->designation;
            $data->save();

            if ($data->id) {
                $folder = public_path('/backend/user/');
                @unlink($folder . $existing_photo);

                UserRole::where('user_id', $data->id)->delete();
                foreach ($request->user_role as $role) {
                    $user_rule          = new UserRole();
                    $user_rule->user_id = $data->id;
                    $user_rule->role_id = $role;
                    $user_rule->save();
                }
            }

            DB::commit();
            if ($request->ajax()) {
                return json_encode(array('status' => true, 'message' => \Lang::get('Data Saved successfully')), true);
            }

            return redirect()->route('admin.user-management.user-info.list', ['id' => $data->id])->with('success', \Lang::get('Data Saved successfully'));
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            if ($request->ajax()) {
                return json_encode(array('status' => false, 'message' => \Lang::get('Data Not Saved')), true);
            }
            return redirect()->back()->with('error', \Lang::get('Data Not Saved'));
        }
    }

    public function show($id = null)
    {
        $data['role_array']      = UserRole::where('user_id', $id)->get()->toArray();
        $data['roles']           = Role::where('id', '!=', 1)->orderBy('sort', 'asc')->get();

        $data['profileData'] = User::where('users.id', $id)
            ->leftJoin('departments', 'departments.id', '=', 'users.department_id')
            ->select('users.*', 'departments.name as department_name_en', 'departments.name_bn as department_name_bn', 'departments.department_no')
            ->first();

        if (!empty($data['profileData'])) {
            $data['profileData']->religion      = (int) $data['profileData']->religion;
            $data['profileData']->status        = (int) $data['profileData']->status;
            //$data['profileData']->photo         = (isset($data['profileData']->photo) && $data['profileData']->photo != '') ? arrayToimage($data['profileData']->photo) : '';

            $data['user'] = $data['profileData'];
            return view('backend.user-management.user-info.show', $data);
        } else {
            return back()->with('error', \Lang::get("No Data Found"));
        }
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('admin.user-management.user-info.list')->with('success', 'Successfully Deleted');
    }

    public function updatePassword(Request $request)
    {
        if ($request->ajax()) {
            $user_id = $request->id;
            if ($user_id > 0) {
                if ($request->password != '' || $request->password != null) {
                    $password = bcrypt($request->password);
                    $done = User::where('id', $user_id)->update(array('password' => $password));
                    if ($done) {
                        return json_encode(array('status' => true, 'message' => 'Data Saved successfully'));
                    } else {
                        return json_encode(array('status' => false, 'message' => 'Data Not Saved'));
                    }
                }
            }
        } else {
            return 'you are not allowed';
        }
    }

    public function myProfile()
    {

        dd('gggg');
        // if(isset(authInfo()->profileData) && isset(authInfo()->profileData['profileID'])){
        //     $data['profileID']       = authInfo()->profileData['profileID'];
        //     return view('backend.profileActivities.profiles.myprofile', $data);
        // }
        // else{
        //     echo '<h2>in progress .....</h2>';
        //     //$data['profileID']       = authInfo()->profileData['profileID'];
        //     //return view('backend.profileActivities.profiles.myprofile', $data);
        // }
    }

    public function profileDetails(Request $request, $type)
    {
        $id = $request->id;
        if ($type == 'view') {
            $data['role_array']      = UserRole::where('user_id', $id)->get()->toArray();
            $data['roles']           = Role::where('id', '!=', 1)->orderBy('sort', 'asc')->get();
        } else if ($type == 'edit') {
            //$data['editData']        = User::find($id);
            $data['role_array']      = UserRole::where('user_id', $id)->get()->toArray();
            $data['roles']           = Role::where('id', '!=', 1)->orderBy('sort', 'asc')->get();
            $data['department_list'] = Department::where('status', 1)->orderBy('id', 'asc')->get();
            $data['user_type_list']  = userTypeList();
            $data['parliaments']     = Parliament::orderBy('id', 'asc')->get();
        }

        $data['profileData'] = User::where('users.id', $id)
            ->leftJoin('departments', 'departments.id', '=', 'users.department_id')
            ->select('users.*', 'departments.name as department_name_en', 'departments.name_bn as department_name_bn', 'departments.department_no')
            ->first();

        if (!empty($data['profileData'])) {
            $data['profileData']->religion      = (int) $data['profileData']->religion;
            $data['profileData']->status        = (int) $data['profileData']->status;
            //$data['profileData']->religion_text = $this->myReligion($data['profileData']->religion);
            //$data['profileData']->status_text   = $this->myStatus($data['profileData']->status);
            // $data['profileData']->photo         = (isset($data['profileData']->photo) && $data['profileData']->photo != '') ? arrayToimage($data['profileData']->photo) : '';
            //$data['profileData']->bloodGroup_text = $this->myBloodGroup($data['profileData']->bloodGroup);
            if (isApi()) {
                $response['status']   = 'success';
                $response['message']  = '';
                $response['api_info'] = $data;
                return response()->json($response);
            }
            if ($type == 'view') {
                return view('backend.user-management.user-info.partial.show', $data);
            }
            if ($type == 'edit') {
                $data['editData']       = $data['profileData'];
                //dd($data['editData']);
                return view('backend.user-management.user-info.partial.edit', $data);
            }
        } else {
            if (isApi()) {
                $response['status']  = 'error';
                $response['message'] = 'Data not Found';
                return response()->json($response);
            }
            return \Lang::get("No Data Found");
        }
    }
}
