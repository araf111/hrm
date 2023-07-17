<?php

namespace App\Http\Controllers\Backend\ProfileActivities;

use App\Http\Controllers\Controller;
use App\Model\V2Profile;
use App\SelectedUser;
use App\SelectedType;
use App\Model\Constituency;
use App\Model\Parliament;
use App\Model\Appointment;
use App\Model\CommitteeMeeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;

class MpBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['current_parliament_number'] = Parliament::where('status', 1)->orderBy('id', 'desc')->first()->parliament_number;
        $data['parliament_list'] = Parliament::orderby('parliament_number', 'desc')->get();
        if (!empty($data['parliament_list'])) {
            foreach ($data['parliament_list'] as $d) {
                $d->parliament_number_bn = \Lang::get($d->parliament_number);
            }
        }
        return view('backend.profileActivities.mpBook.index_new', $data);
    }

    public function showMpBook(Request $request, $type = 'mpbook')
    {
        //dd($request->all());
        if ($type == 'mpbook') {
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
                ->where('v2_profiles.parliamentNumber', $parliamentNumber)
                ->where('constituencies.deleted_at', null)
                ->where($where)
                ->select('v2_profiles.*', 'constituencies.number as bangladesh_number', 'constituencies.name as voter_area_eng', 'constituencies.bn_name as voter_area_bng')
                ->orderBy('constituencyNumber', 'asc');

            if (isApi()) {
                $response['status']   = 'success';
                $response['message']  = '';
                $response['api_info'] = $profile_list->get();
                return response()->json($response);
            }

            return Datatables::of($profile_list)
                ->editColumn('mp_name', function ($row) {
                    if (session()->get('language') == 'bn') {
                        $row->nameBng = $row->nameBng;
                    } else {
                        $row->nameBng = $row->nameEng;
                    }
                    return '<img src="' . asset('/public/backend/profile/' . $row->photo) . '" class="ml-2 img-circle elevation-2" alt="" style="width: 35px;"> ' . $row->nameBng;
                })
                ->addColumn('present_address', function ($row) {
                    if (session()->get('language') == 'bn') {
                        $row->present_address = $row->presentAddressBng;
                    } else {
                        $row->present_address = $row->presentAddressEng;
                    }
                    return $row->present_address;
                })
                ->addColumn('voter_area_bng', function ($row) {
                    if (session()->get('language') == 'bn') {
                        $row->voter_area_bng = $row->voter_area_bng;
                    } else {
                        $row->voter_area_bng = $row->voter_area_eng;
                    }
                    return $row->voter_area_bng;
                })
                ->editColumn('bangladesh_number', function ($row) {
                    return digitDateLang($row->bangladesh_number);
                })
                ->editColumn('personalMobile', function ($row) {
                    return digitDateLang($row->personalMobile);
                })

                ->addColumn('action', function ($row) use ($request) {
                    $action_for_admin = '<a href="' . route("admin.profile-activities.v2profiles.edit", $row->profileID) . '"class="btn btn-sm btn-info" target="_blank"><i class="fa fa-edit"></i></a> <a href="' . route("admin.profile-activities.v2profiles.show", $row->profileID) . '"
                    class="btn btn-sm btn-success" target="_blank"><i class="fa fa-eye"></i></a> <button type="button" class="btn btn-info" onClick=load_report("pdf","' . $row->profileID . '")><i class="fa fa-file-pdf"> </i></button>';
                    $action_for_non_admin = '<a href="' . route("admin.profile-activities.v2profiles.show", $row->profileID) . '" class="btn btn-sm btn-success" target="_blank"><i class="fa fa-eye"></i></a> <button type="button" class="btn btn-info" onClick=load_report("pdf","' . $row->profileID . '")><i class="fa fa-file-pdf"> </i></button>';

                    $action_line = (authInfo()->usertype == 'admin') ? $action_for_admin : $action_for_non_admin;
                    return $action_line;
                })
                ->addIndexColumn()
                ->escapeColumns([]) // to render html
                ->make(true);

            //$data['mp_list'] = $profile_list;
            //dd($profile_list);
            /* $final_result = '<table id="list_mp_table" class="table table-sm table-bordered table-striped"> <thead> <tr><th>' . \Lang::get("Serial") . '</th><th>' . \Lang::get("Name") . '</th><th>'.\Lang::get("Bangladesh No.") . '</th><th>' . \Lang::get("Constituency") . '</th> <th>' . \Lang::get("Phone") . '</th><th>' . \Lang::get("Action") . '</th></tr></thead><tbody>';
            if (count($profile_list) > 0) {
                $sn=1;
                foreach ($profile_list as $p) {
                    if(session()->get('language')=='bn'){
                        $p->mp_name = $p->nameBng;
                        $p->voter_area = $p->voter_area_bng;
                    }
                    else{
                        $p->mp_name = $p->nameEng;
                        $p->voter_area = $p->voter_area_bng;
                    }

                    $action_for_admin = '<a href="'.route("admin.profile-activities.v2profiles.edit", $p->profileID).'"class="btn btn-sm btn-info" target="_blank"><i class="fa fa-edit"></i></a> <a href="'. route("admin.profile-activities.v2profiles.show", $p->profileID).'"
                    class="btn btn-sm btn-success" target="_blank"><i class="fa fa-eye"></i></a> <button type="button" class="btn btn-info" onClick=load_report("pdf","'.$p->profileID.'")>'.\Lang::get("PDF").'</button>';
                    $action_for_non_admin = '<a href="'. route("admin.profile-activities.v2profiles.show", $p->profileID).'" class="btn btn-sm btn-success" target="_blank"><i class="fa fa-eye"></i></a> <button type="button" class="btn btn-info" onClick=load_report("pdf","'.$p->profileID.'")>'.\Lang::get("PDF").'</button>';

                    $action_line = (authInfo()->usertype=='admin')?$action_for_admin:$action_for_non_admin;


                    $final_result .= '<tr><td>'.digitDateLang($sn++).'</td><td><img src="'.$p->photo.'" class="ml-2 img-circle elevation-2" alt="" style="width: 35px;"> '.$p->mp_name.'</td><td>'.digitDateLang($p->bangladesh_number).'</td><td>'.$p->voter_area.'</td><td>'.$p->personalMobile.'</td><td>'.$action_line.'</td></tr>';
                }
            }
            $final_result .= '</tbody></table>';
            return json_encode(array('status'=>true,'data'=>$final_result)); */
        } else if ($type == 'profile') {
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
                ->where('v2_profiles.parliamentNumber', $parliamentNumber)
                ->where('constituencies.deleted_at', null)
                ->where($where)
                ->select('v2_profiles.*', 'constituencies.number as bangladesh_number', 'constituencies.name as voter_area_eng', 'constituencies.bn_name as voter_area_bng')
                ->orderBy('constituencyNumber', 'asc');
            //dd($profile_list);


            return Datatables::of($profile_list)
                ->editColumn('profileID', function ($row) {
                    return digitDateLang($row->profileID);
                })
                ->editColumn('mp_name', function ($row) {
                    if (session()->get('language') == 'bn') {
                        $row->nameBng = $row->nameBng;
                    } else {
                        $row->nameBng = $row->nameEng;
                    }
                    return '<img src="' . asset('/public/backend/profile/' . $row->photo) . '" class="ml-2 img-circle elevation-2" alt="" style="width: 35px;"> ' . $row->nameBng;
                })
                ->addColumn('voter_area_bng', function ($row) {
                    if (session()->get('language') == 'bn') {
                        $row->voter_area_bng = $row->voter_area_bng;
                    } else {
                        $row->voter_area_bng = $row->voter_area_eng;
                    }
                    return $row->voter_area_bng;
                })
                ->editColumn('bangladesh_number', function ($row) {
                    return digitDateLang($row->bangladesh_number);
                })
                ->editColumn('personalMobile', function ($row) {
                    return digitDateLang($row->personalMobile);
                })

                ->addColumn('action', function ($row) use ($request) {
                    $action_for_admin = '<a href="' . route("admin.profile-activities.v2profiles.edit", $row->profileID) . '"class="btn btn-sm btn-info" target="_blank"><i class="fa fa-edit"></i></a> <a href="' . route("admin.profile-activities.v2profiles.show", $row->profileID) . '"
                    class="btn btn-sm btn-success" target="_blank"><i class="fa fa-eye"></i></a> <button type="button" class="btn btn-info" onClick=load_report("pdf","' . $row->profileID . '")><i class="fa fa-file-pdf"> </i></button>';
                    $action_for_non_admin = '<a href="' . route("admin.profile-activities.v2profiles.show", $row->profileID) . '" class="btn btn-sm btn-success" target="_blank"><i class="fa fa-eye"></i></a> <button type="button" class="btn btn-info" onClick=load_report("pdf","' . $row->profileID . '")><i class="fa fa-file-pdf"> </i></button>';

                    $action_line = (authInfo()->usertype == 'admin') ? $action_for_admin : $action_for_non_admin;
                    return $action_line;
                })
                ->addIndexColumn()
                ->escapeColumns([]) // to render html
                ->make(true);


            /* $profile_list = V2Profile::where('constituencies.parliamentNumber', $parliamentNumber)
                ->leftJoin('constituencies', 'constituencies.number', '=', 'v2_profiles.constituencyNumber')
                ->where('v2_profiles.parliamentNumber', $parliamentNumber)
                ->where($where)
                ->select('v2_profiles.*', 'constituencies.number as bangladesh_number', 'constituencies.name as voter_area_eng', 'constituencies.bn_name as voter_area_bng')
                ->orderBy('constituencyNumber', 'asc')->get();
            //$data['mp_list'] = $profile_list;
            //dd($profile_list);
            $final_result = '<table id="list_mp_table" class="table table-sm table-bordered table-striped"> <thead> <tr><th>' . \Lang::get("Serial") . '</th><th>' . \Lang::get("Name") . '</th><th>' . \Lang::get("Bangladesh No.") . '</th><th>' . \Lang::get("Constituency") . '</th> <th>' . \Lang::get("Phone") . '</th><th>' . \Lang::get("Action") . '</th></tr></thead><tbody>';
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
                    class="btn btn-sm btn-success" target="_blank"><i class="fa fa-eye"></i></a> <button type="button" class="btn btn-info" onClick=load_report("pdf","' . $p->profileID . '")>' . \Lang::get("PDF") . '</button>';
                    $action_for_non_admin = '<a href="' . route("admin.profile-activities.v2profiles.show", $p->profileID) . '" class="btn btn-sm btn-success" target="_blank"><i class="fa fa-eye"></i></a> <button type="button" class="btn btn-info" onClick=load_report("pdf","' . $p->profileID . '")>' . \Lang::get("PDF") . '</button>';

                    $action_line = (authInfo()->usertype == 'admin') ? $action_for_admin : $action_for_non_admin;


                    $final_result .= '<tr><td>' . digitDateLang($sn++) . '</td><td><img src="' . $p->photo . '" class="ml-2 img-circle elevation-2" alt="" style="width: 35px;"> ' . $p->mp_name . '</td><td>' . digitDateLang($p->bangladesh_number) . '</td><td>' . $p->voter_area . '</td><td>' . $p->personalMobile . '</td><td>' . $action_line . '</td></tr>';
                }
            }
            $final_result .= '</tbody></table>';
            return json_encode(array('status' => true, 'data' => $final_result)); */
        }
    }

    public function personTypeList()
    {
        //get type of users
        $data['person_types'] = SelectedType::where('status', 1)->select('id', 'name_bn', 'name_en')->get();

        $collection  = collect(array(array('id' => 0, 'name_bn' => 'এম পি মহোদয়', 'name_en' => 'MP')));
        $merged      = $collection->merge($data['person_types']);
        $data['person_types'] = $merged->all();

        if (isApi()) {
            $response['status']   = 'success';
            $response['message']  = '';
            $response['api_info'] = $data;
            return response()->json($response);
        }
    }

    public function mpNet(Request $request)
    {
        //get person type: 0=mp, the rest of types will be listed from selected_users table
        $person_type = $request->person_type;

        if ($person_type == 0) {
            if (isset($request->parliamentNumber) && $request->parliamentNumber != '') {
                $parliamentNumber = $request->parliamentNumber;
            } else {
                $current_parliament_data = Parliament::where('status', 1)->orderBy('id', 'desc')->first();
                $parliamentNumber = $current_parliament_data->parliament_number;
            }
            //get mp list from v2_profile table
            $data['person_list'] = V2Profile::where('parliamentNumber', $parliamentNumber)->select('nameEng as name', 'nameBng', 'personalMobile as mobile_number', 'email', 'photo')->get();
            if (count($data['person_list']) > 0) {
                foreach ($data['person_list'] as $p) {
                    if ($p->photo != '') {
                        $p->photo = url('/').'/public/backend/profile/' . $p->photo;
                    }
                }
            }
        } else {
            //get mp list from v2_profile table
            $data['person_list'] = SelectedUser::where('selected_type', $person_type)->select('name', 'mobile_num as mobile_number', 'email', 'image as photo')->get();
            if (count($data['person_list']) > 0) {
                foreach ($data['person_list'] as $p) {
                    if ($p->photo != '') {
                        $p->photo = url('/').'/public/backend/selected_person/' . $p->photo;
                    }
                }
            }
        }
        if (isApi()) {
            $response['status']   = 'success';
            $response['message']  = '';
            $response['api_info'] = $data;
            return response()->json($response);
        }
    }

    public function myCalendar(Request $request)
    {
        if (isset($request->date) && $request->date != '') {
            $date = date('Y-m-d', strtotime($request->date));
            //for appointment
            $data['appointment_request_list'] = Appointment::where('appointments.created_by', authInfo()->id)
                ->where('appointments.date', $date)
                ->leftJoin('v2_profiles', 'v2_profiles.user_id', '=', 'appointments.requested_to')
                ->select('appointments.*', 'v2_profiles.nameEng as request_to_name_eng', 'v2_profiles.nameBng as request_to_name_bng')
                ->get();

            $data['appointment_received_list'] = Appointment::where('appointments.requested_to', authInfo()->id)
                ->where('appointments.date', $date)
                ->leftJoin('v2_profiles', 'v2_profiles.user_id', '=', 'appointments.created_by')
                ->select('appointments.*', 'v2_profiles.nameEng as request_by_name_eng', 'v2_profiles.nameBng as request_by_name_bng')
                ->get();

            //Standing committee meeting for current logged in user
            //$query = "SELECT m.*,u.user_id,c.committee_name FROM committee_meetings m left join standing_committee_members u on u.id = m.new_standing_committees_id left join new_standing_committees c on c.id=m.new_standing_committees_id where m.date_meeting='2021-10-28' and u.user_id=2 ";
            $data['meeting_list'] = CommitteeMeeting::where('committee_meetings.date_meeting', $date)
                ->where('standing_committee_members.user_id', authInfo()->id)
                ->leftJoin('standing_committee_members', 'standing_committee_members.id', '=', 'committee_meetings.new_standing_committees_id')
                ->leftJoin('new_standing_committees', 'new_standing_committees.id', '=', 'committee_meetings.new_standing_committees_id')
                ->select('committee_meetings.*', 'standing_committee_members.user_id', 'new_standing_committees.committee_name')
                ->get();

            if (isApi()) {
                $response['status']   = 'success';
                $response['api_info'] = $data;
                return response()->json($response);
            }

            if (count($data) > 0) {
                return json_encode(array('status' => true, 'data' => $data));
            } else {
                return json_encode(array('status' => false, 'data' => []));
            }
        } else {
            if (isApi()) {
                $response['status']   = 'error';
                $response['message'] = 'No Data Found';
                return response()->json($response);
            }
            return json_encode(array('status' => false, 'data' => []));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $designation_id = $request->input('bd_no');
        $division_id = $request->input('division_id');
        $district_id = $request->input('district_id');
        $constituency_id = $request->input('constituency_id');
        $search_by = $request->input('search_by');
        $where = [];
        $whereHas = [];

        //echo $designation_id.'/'.$division_id.'/'.$district_id.'/'.$constituency_id.'/'.$search_by;
        //die();
        //dd($request);
        //    if($request->constituency_id){
        //         $where = ['constituency_id' => $constituency_id];
        //     }elseif($request->district_id){
        //         $where = ['designation_id' => $designation_id];
        //         $whereHas = ['district_id' => $district_id];
        //     }elseif ($request->division_id) {
        //         $where = ['designation_id' => $designation_id];
        //         $whereHas = ['division_id' => $division_id];
        //     }elseif($request->designation_id){
        //         $where = ['designation_id' => $designation_id];
        //     }else {
        //         $data = [];
        //     }
        // dd($where);
        /* if($constituency_id){
            $data =  DB::table('constituencies')
            ->join('profiles', 'constituencies.number', '=', 'profiles.constituency_id')
            ->select('profiles.*','constituencies.*')->where('constituencies.number', $constituency_id)->get();
        }
        elseif($district_id){
            $data =  DB::table('constituencies')
            ->join('profiles', 'constituencies.number', '=', 'profiles.constituency_id')
            ->select('profiles.*','constituencies.*')->where('constituencies.district_id', $district_id)->get();
        }
        elseif($division_id){
            $data =  DB::table('constituencies')
            ->join('profiles', 'constituencies.number', '=', 'profiles.constituency_id')
            ->select('profiles.*','constituencies.*')->where('constituencies.division_id', $division_id)->get();
        }
        else{
            $data =  DB::table('constituencies')
            ->join('profiles', 'constituencies.number', '=', 'profiles.constituency_id')
            ->select('profiles.*','constituencies.*')->where('constituencies.number', $designation_id)->get();
            // $data = Profile::where('constituency_id',$designation_id)->get();
        } */

        $query = "select p.*,c.number as bn_number,c.bn_name as voter_area_bn, c.name as voter_area_en from profiles p left join constituencies c on c.id = p.constituency_id where p.id>0 ";

        if ($designation_id) {
            $query .= " and c.number = " . $designation_id;
        }
        if ($constituency_id) {
            $query .= " and c.id = " . $constituency_id;
        }
        if ($district_id) {
            $query .= " and c.district_id = " . $district_id;
        }
        if ($division_id) {
            $query .= " and c.division_id = " . $division_id;
        }

        /* echo $query;
        die(); */

        $data =  DB::select($query);

        // return view('backend.profileActivities.mpBook.index', compact('data'));
        $data1['data'] = $data;
        return view('backend.profileActivities.mpBook.mpBook', $data1);
        // return $data;
        // $data = Profile::where('constituency_id',$data)->get();

        // $data = Profile::where('designation_id', $designation_id)
        // ->orWhere('constituency_id', $constituency_id)
        // ->orWhere('name_eng', 'LIKE', '%' . $search_by . '%')
        // ->orWhereHas('constituency', function ($q) use ($division_id) {
        //     $q->where('division_id', $division_id);
        // })
        // ->orWhereHas('constituency', function ($q) use ($district_id) {
        //     $q->where('district_id', $district_id);
        // })
        // ->get();



        //     $designation_id = $request->input('designation_id');
        //     $division_id = $request->input('division_id');
        //     $district_id = $request->input('district_id');
        //     $constituency_id = $request->input('constituency_id');
        //     $search_by = $request->input('search_by');
        //     $where = [];
        //     $whereHas = [];

        //    if($request->constituency_id){
        //         $where = ['constituency_id' => $constituency_id];
        //     }elseif($request->district_id){
        //         $where = ['designation_id' => $designation_id];
        //         $whereHas = ['district_id' => $district_id];
        //     }elseif ($request->division_id) {
        //         $where = ['designation_id' => $designation_id];
        //         $whereHas = ['division_id' => $division_id];
        //     }elseif($request->designation_id){
        //         $where = ['designation_id' => $designation_id];
        //     }else {
        //         $data = [];
        //     }
        //     // dd($where);
        //     if($where && $request->search_by){
        //         $data = Profile::where($where)
        //         ->whereHas('constituency', function ($q) use ($whereHas) {
        //                 $q->where($whereHas);
        //         })
        //         ->where('name_eng', 'LIKE', '%' . $search_by . '%')
        //         ->get();
        //     }elseif($where){
        //         $data = Profile::where($where)
        //         ->whereHas('constituency', function ($q) use ($whereHas) {
        //                 $q->where($whereHas);
        //         })
        //         ->get();
        //     }elseif($request->search_by){
        //         $data = Profile::where('name_eng', 'LIKE', '%' . $search_by . '%')
        //         ->get();
        //     }else{
        //         $data = [];
        //     }

        // dd($data->toArray());
        return view('backend.profileActivities.mpBook.index', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
}
