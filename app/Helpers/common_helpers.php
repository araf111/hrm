<?php

use App\Model\AccommodationApplication;
use App\Model\AccommodationApplicationType;
use App\Model\AccommodationApprovalStep;
use App\Model\AccommodationLog;
use App\Model\AccommodationStepLog;
use App\Model\Area;
use App\Model\Constituency;
use App\Model\Designation;
use App\Model\District;
use App\Model\Division;
use App\Model\FileCategory;
use App\Model\FlatLog;
use App\Model\HostelApplication;
use App\Model\HostelApprovalStep;
use App\Model\HostelLog;
use App\Model\HostelStepLog;
use App\Model\MenuPermission;
use App\Model\MenuRoute;
use App\Model\Ministry;
use App\Model\MpPs;
use App\Model\OfficeRoomLog;
use App\Model\Parliament;
use App\Model\ParliamentBillSubClause;
use App\Model\ParliamentSession;
use App\Model\PoliticalParty;
use App\Model\Profile;
use App\Model\ProggaponCategory;
use App\Model\V2Profile;
use App\SelectedUser;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Http;

if (!function_exists('isApi')) {
    function isApi()
    {
        return Str::startsWith(request()->path(), 'api');
    }
}

if (!function_exists('FlatLogData')) {
    function FlatLogData($flat_id = null, $old_data = null, $new_data = null, $action = null)
    {
        $server_info['Server Name']    = $_SERVER['SERVER_NAME'];
        $server_info['Server Address'] = $_SERVER['SERVER_ADDR'];
        $server_info['Server Port']    = $_SERVER['SERVER_PORT'];
        $server_info['Remote Address'] = $_SERVER['REMOTE_ADDR'];
        $server_info['Request Time']   = date('d-m-Y H:i:s A', $_SERVER['REQUEST_TIME']);

        $store                               = new FlatLog();
        $store->flat_id = $flat_id;
        $store->old_data                     = json_encode($old_data);
        $store->new_data                     = json_encode($new_data);
        $store->action                       = $action;
        $store->server_info                  = json_encode($server_info);
        $store->created_by                   = authInfo()->id;
        $store->save();
        return true;
    }
}

if (!function_exists('OfficeRoomLogData')) {
    function OfficeRoomLogData($office_room_id = null, $old_data = null, $new_data = null, $action = null)
    {
        $server_info['Server Name']    = $_SERVER['SERVER_NAME'];
        $server_info['Server Address'] = $_SERVER['SERVER_ADDR'];
        $server_info['Server Port']    = $_SERVER['SERVER_PORT'];
        $server_info['Remote Address'] = $_SERVER['REMOTE_ADDR'];
        $server_info['Request Time']   = date('d-m-Y H:i:s A', $_SERVER['REQUEST_TIME']);

        $store                               = new OfficeRoomLog();
        $store->office_room_id = $office_room_id;
        $store->old_data                     = json_encode($old_data);
        $store->new_data                     = json_encode($new_data);
        $store->action                       = $action;
        $store->server_info                  = json_encode($server_info);
        $store->created_by                   = authInfo()->id;
        $store->save();
        return true;
    }
}

if (!function_exists('AccommodationLogData')) {
    function AccommodationLogData($accommodation_application_id = null, $old_data = null, $new_data = null, $action = null)
    {
        $server_info['Server Name']    = $_SERVER['SERVER_NAME'];
        $server_info['Server Address'] = $_SERVER['SERVER_ADDR'];
        $server_info['Server Port']    = $_SERVER['SERVER_PORT'];
        $server_info['Remote Address'] = $_SERVER['REMOTE_ADDR'];
        $server_info['Request Time']   = date('d-m-Y H:i:s A', $_SERVER['REQUEST_TIME']);

        $store                               = new AccommodationLog();
        $store->accommodation_application_id = $accommodation_application_id;
        $store->old_data                     = json_encode($old_data);
        $store->new_data                     = json_encode($new_data);
        $store->action                       = $action;
        $store->server_info                  = json_encode($server_info);
        $store->created_by                   = authInfo()->id;
        $store->save();
        return true;
    }
}

if (!function_exists('HostelLogData')) {
    function HostelLogData($hostel_application_id = null, $old_data = null, $new_data = null, $action = null)
    {
        $server_info['Server Name']    = $_SERVER['SERVER_NAME'];
        $server_info['Server Address'] = $_SERVER['SERVER_ADDR'];
        $server_info['Server Port']    = $_SERVER['SERVER_PORT'];
        $server_info['Remote Address'] = $_SERVER['REMOTE_ADDR'];
        $server_info['Request Time']   = date('d-m-Y H:i:s A', $_SERVER['REQUEST_TIME']);

        $store                               = new HostelLog();
        $store->hostel_application_id = $hostel_application_id;
        $store->old_data                     = json_encode($old_data);
        $store->new_data                     = json_encode($new_data);
        $store->action                       = $action;
        $store->server_info                  = json_encode($server_info);
        $store->created_by                   = authInfo()->id;
        $store->save();
        return true;
    }
}

if (!function_exists('AccommodationPendingApprovalRejectStepStatus')) {
    function AccommodationPendingApprovalRejectStepStatus()
    {
        $where           = [];
        $user_role_array = authInfo()->user_role;
        if (count($user_role_array) == 0) {
            $user_role = [];
        } else {
            foreach ($user_role_array as $rolee) {
                $user_role[] = $rolee->role_id;
            }
        }

        $steps = AccommodationApprovalStep::whereIn('role_id', $user_role)->orderBy('step', 'asc')->get();

        $data['pending']['step']    = [];
        $data['pending']['status']  = [];
        $data['approval']['step']   = [];
        $data['approval']['status'] = [];
        $data['reject']['step']     = [];
        $data['reject']['status']   = [];
        foreach ($steps as $key => $step) {
            $data['pending']['step'][] = $step->step;
            $data['pending']['status'] = [1];

            $data['approval']['step']   = [1, 2, 3, 4, 5, 6, 7, 8];
            $data['approval']['status'] = [1, 2, 3, 4];

            $data['reject']['step'][] = $step->step;
            $data['reject']['status'] = [3];
        }
        return $data;
    }
}


if (!function_exists('HostelPendingApprovalRejectStepStatus')) {
    function HostelPendingApprovalRejectStepStatus()
    {
        $where           = [];
        $user_role_array = authInfo()->user_role;
        if (count($user_role_array) == 0) {
            $user_role = [];
        } else {
            foreach ($user_role_array as $rolee) {
                $user_role[] = $rolee->role_id;
            }
        }

        $steps = HostelApprovalStep::whereIn('role_id', $user_role)->orderBy('step', 'asc')->get();

        $data['pending']['step']    = [];
        $data['pending']['status']  = [];
        $data['approval']['step']   = [];
        $data['approval']['status'] = [];
        $data['reject']['step']     = [];
        $data['reject']['status']   = [];
        foreach ($steps as $key => $step) {
            $data['pending']['step'][] = $step->step;
            $data['pending']['status'] = [1];

            $data['approval']['step']   = [1, 2, 3, 4, 5, 6, 7, 8];
            $data['approval']['status'] = [1, 2, 3, 4];

            $data['reject']['step'][] = $step->step;
            $data['reject']['status'] = [3];
        }
        return $data;
    }
}

if (!function_exists('AccessRole')) {
    function AccessRole($user_roles)
    {
        $role = '';
        foreach ($user_roles as $key => $user_role) {
            if ($key != 0) {
                $role .= ' , ';
            }
            $role .= "<span class='badge badge-success'>" . @$user_role['role_details']['name'] . "</span>";
        }

        return $role;
    }
}

if (!function_exists('accommodationStatusApi')) {
    function accommodationStatusApi($accommodation_application_id)
    {
        $application = AccommodationApplication::find($accommodation_application_id);
        if ($application->status == 0) {
            $data['status_number'] = $application->status;
            $data['en'] = "Draft";
            $data['bn'] = "খসড়া";
        }

        if ($application->status == 1) {
            $accommodation_approval_step = AccommodationApprovalStep::where('step', $application->step)->orderBy('step', 'asc')->first();
            $data['status_number'] = $application->status;
            $data['en'] = 'Pending ( ' . @$accommodation_approval_step['role']['name'] . ' )';
            $data['bn'] = 'বিবেচনাধীন ( ' . @$accommodation_approval_step['role']['name_bn'] . ' )';
        }

        if ($application->status == 2) {
            $data['status_number'] = $application->status;
            $data['en'] = 'Approved';
            $data['bn'] = 'এপ্রুভ';
        }

        if ($application->status == 3) {
            $accommodation_approval_step = AccommodationStepLog::where('accommodation_application_id', $application->id)->where('step', $application->step)->first();
            $data['status_number'] = $application->status;
            $data['en'] = 'Reject (' . @$accommodation_approval_step['accommodation_approval_step']['role']['name'] . ')';
            $data['bn'] = 'বাতিল (' . @$accommodation_approval_step['accommodation_approval_step']['role']['name_bn'] . ')';
        }

        if ($application->status == 4) {
            $data['status_number'] = $application->status;
            $data['en'] = 'Inactive';
            $data['bn'] = 'নিষ্ক্রিয়';
        }
        return $data;
    }
}

if (!function_exists('accommodationStatus')) {
    function accommodationStatus($accommodation_application_id)
    {
        $application = AccommodationApplication::find($accommodation_application_id);
        if ($application->status == 0) {
            if (session()->get('language') == 'bn') {
                echo '<span class="badge badge-default">খসড়া</span>';
            } else {
                echo '<span class="badge badge-default">Draft</span>';
            }
        }

        if ($application->status == 1) {
            $accommodation_approval_step = AccommodationApprovalStep::where('step', $application->step)->orderBy('step', 'asc')->first();
            if (session()->get('language') == 'bn') {
                echo '<span class="badge badge-info">বিবেচনাধীন ( ' . @$accommodation_approval_step['role']['name_bn'] . ' )</span>';
            } else {
                echo '<span class="badge badge-info">Pending ( ' . @$accommodation_approval_step['role']['name'] . ' )</span>';
            }
        }

        if ($application->status == 2) {
            if (session()->get('language') == 'bn') {
                echo '<span class="badge badge-success">এপ্রুভ</span>';
            } else {
                echo '<span class="badge badge-success">Approved</span>';
            }
        }

        if ($application->status == 3) {
            $accommodation_approval_step = AccommodationStepLog::where('accommodation_application_id', $application->id)->where('step', $application->step)->first();
            if (session()->get('language') == 'bn') {
                echo '<span class="badge badge-danger">বাতিল (' . @$accommodation_approval_step['accommodation_approval_step']['role']['name_bn'] . ') </span>';
            } else {
                echo '<span class="badge badge-danger">Reject (' . @$accommodation_approval_step['accommodation_approval_step']['role']['name'] . ') </span>';
            }
        }

        if ($application->status == 4) {
            if (session()->get('language') == 'bn') {
                echo '<span class="badge badge-danger">নিষ্ক্রিয় </span>';
            } else {
                echo '<span class="badge badge-danger">Inactive </span>';
            }
        }
    }
}



if (!function_exists('hostelStatusApi')) {
    function hostelStatusApi($hostel_application_id)
    {
        $application = HostelApplication::find($hostel_application_id);
        if ($application->status == 0) {
            $data['status_number'] = $application->status;
            $data['en'] = "Draft";
            $data['bn'] = "খসড়া";
        }

        if ($application->status == 1) {
            $hostel_approval_step = HostelApprovalStep::where('step', $application->step)->orderBy('step', 'asc')->first();
            $data['status_number'] = $application->status;
            $data['en'] = 'Pending ( ' . @$hostel_approval_step['role']['name'] . ' )';
            $data['bn'] = 'বিবেচনাধীন ( ' . @$hostel_approval_step['role']['name_bn'] . ' )';
        }

        if ($application->status == 2) {
            $data['status_number'] = $application->status;
            $data['en'] = 'Approved';
            $data['bn'] = 'এপ্রুভ';
        }

        if ($application->status == 3) {
            $hostel_approval_step = HostelStepLog::where('hostel_application_id', $application->id)->where('step', $application->step)->first();
            $data['status_number'] = $application->status;
            $data['en'] = 'Reject (' . @$hostel_approval_step['hostel_approval_step']['role']['name'] . ')';
            $data['bn'] = 'বাতিল (' . @$hostel_approval_step['hostel_approval_step']['role']['name_bn'] . ')';
        }

        if ($application->status == 4) {
            $data['status_number'] = $application->status;
            $data['en'] = 'Inactive';
            $data['bn'] = 'নিষ্ক্রিয়';
        }
        return $data;
    }
}


if (!function_exists('hostelStatus')) {
    function hostelStatus($hostel_application_id)
    {
        $application = HostelApplication::find($hostel_application_id);
        if ($application->status == 0) {
            if (session()->get('language') == 'bn') {
                echo '<span class="badge badge-default">খসড়া</span>';
            } else {
                echo '<span class="badge badge-default">Draft</span>';
            }
        }

        if ($application->status == 1) {
            $hostel_approval_step = HostelApprovalStep::where('step', $application->step)->orderBy('step', 'asc')->first();
            if (session()->get('language') == 'bn') {
                echo '<span class="badge badge-info">বিবেচনাধীন ( ' . @$hostel_approval_step['role']['name_bn'] . ' )</span>';
            } else {
                echo '<span class="badge badge-info">Pending ( ' . @$hostel_approval_step['role']['name'] . ' )</span>';
            }
        }

        if ($application->status == 2) {
            if (session()->get('language') == 'bn') {
                echo '<span class="badge badge-success">এপ্রুভ</span>';
            } else {
                echo '<span class="badge badge-success">Approved</span>';
            }
        }

        if ($application->status == 3) {
            $hostel_approval_step = HostelStepLog::where('hostel_application_id', $application->id)->where('step', $application->step)->first();
            if (session()->get('language') == 'bn') {
                echo '<span class="badge badge-danger">বাতিল (' . @$hostel_approval_step['hostel_approval_step']['role']['name_bn'] . ') </span>';
            } else {
                echo '<span class="badge badge-danger">Reject (' . @$hostel_approval_step['hostel_approval_step']['role']['name'] . ') </span>';
            }
        }

        if ($application->status == 4) {
            if (session()->get('language') == 'bn') {
                echo '<span class="badge badge-danger">নিষ্ক্রিয় </span>';
            } else {
                echo '<span class="badge badge-danger">Inactive </span>';
            }
        }
    }
}

function bn2en($number)
{
    $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "AM", "PM", "am", "pm", "cusec", "litre", "horse", "Jan", "Feb", "Mar", "Apr", "May", "Jun", 'Jul', "Aug", "Sep", "Oct", "Nov", "Dec", "January", "February", "March", "April", "May", "June", 'July', "August", "September", "October", "November", "December", "Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Weekend", "day", "week", "month", "year");
    $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০", "এ.এম", "পি.এম", "এ.এম", "পি.এম", "কিউসেক", "লিটার/সে.", "অশ্বশক্তি", "জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "অগাস্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর", "জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "অগাস্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর", "শনিবার", "রবিবার", "সোমবার", "মঙ্গলবার", "বুধবার", "বৃহস্পতিবার", "শুক্রবার", "সাপ্তাহিক ছুটি", "দিন", "সপ্তাহ", "মাস", "বছর");
    return str_replace($bn, $en, $number);
}

function en2bn($number)
{
    $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "AM", "PM", "am", "pm", "cusec", "litre", "horse", "Jan", "Feb", "Mar", "Apr", "May", "Jun", 'Jul', "Aug", "Sep", "Oct", "Nov", "Dec", "January", "February", "March", "April", "May", "June", 'July', "August", "September", "October", "November", "December", "Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Weekend", "day", "week", "month", "year");
    $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০", "এ.এম", "পি.এম", "এ.এম", "পি.এম", "কিউসেক", "লিটার/সে.", "অশ্বশক্তি", "জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "অগাস্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর", "জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "অগাস্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর", "শনিবার", "রবিবার", "সোমবার", "মঙ্গলবার", "বুধবার", "বৃহস্পতিবার", "শুক্রবার", "সাপ্তাহিক ছুটি", "দিন", "সপ্তাহ", "মাস", "বছর");
    return str_replace($en, $bn, $number);
}

function letteren2bn($number)
{
    $en = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13');
    $bn = array('ক', 'খ', 'গ', 'ঘ', 'ঙ', 'চ', 'ছ', 'জ', 'ঝ', 'ঞ', 'ট', 'ঠ', 'ড');
    return str_replace($en, $bn, $number);
}
if (!function_exists('userIdToProfileId')) {
    function userIdToProfileId()
    {
        return authInfo()->id;
        /*  // if (isApi()) {
        //     return auth('api')->user();
        // } else {
        //     return auth()->user();
        // }
        $profileInfo = Profile::where('user_id', authInfo()->id)->first();
        if ($profileInfo) {
            return $profileInfo->id;
        } else {
            return 0;
        } */
    }
}

function userIdToProfileInfo($user_id)
{
    $profileInfo = Profile::where('user_id', $user_id)->first();
    if ($profileInfo) {
        return $profileInfo;
    } else {
        return false;
    }
}

function mpProfileInfo($user_id)
{
    //where('v2_profiles.profileID', authInfo()->profileData['profileID'])
    $profileInfo = V2Profile::where('v2_profiles.status', 1,'v2_profiles.profileID')
        ->where('user_id', $user_id)
        ->leftJoin('parliaments', 'v2_profiles.parliamentNumber', '=', 'parliaments.parliament_number')
        ->leftJoin('designations', 'v2_profiles.designation_id', '=', 'designations.id')
        ->leftJoin('political_parties', 'v2_profiles.political_parties_id', '=', 'political_parties.id')
        ->leftJoin('constituencies', 'v2_profiles.constituencyNumber', '=', 'constituencies.number')
        ->select('v2_profiles.*', 'parliaments.parliament_number', 'designations.name_bn as designation_name',
            'political_parties.name_bn as political_party_name', 'constituencies.bn_name as voter_area', 'constituencies.number as bangladesh_number')
        ->first();


//    $profileInfo = Profile::select('profiles.*', 'parliaments.parliament_number', 'constituencies.bn_name', 'constituencies.number')
//        ->where("user_id", $user_id)
//        ->join('parliaments', 'parliaments.id', '=', 'profiles.user_id')
//        ->join('constituencies', 'constituencies.id', '=', 'profiles.user_id')
//        ->first();


    if ($profileInfo) {
        return $profileInfo;
    } else {
        return false;
    }
}

if (!function_exists('authInfo')) {
    function authInfo()
    {
        if (isApi()) {
            if(Str::startsWith(request()->path(), 'api/nirbachok')){
                //get MP ID from this logged in nirbachok
                $mp_info = SelectedUser::where('id',auth('nirbachok')->user()->id)->first();
                if(!empty($mp_info)){
                    auth('nirbachok')->user()->id = $mp_info->mp_id;
                }
                return auth('nirbachok')->user();
            }
            else{
                return auth('api')->user();
            }
        }
        else {
            // if (auth()->user()->usertype == 'mp') {
            //     $profileInfo = V2Profile::where('user_id', auth()->user()->id)->first();
            //     auth()->user()->profileData = (!empty($profileInfo) && $profileInfo->id > 0) ? $profileInfo : [];
            // }
            return auth()->user();
        }
    }
}

if (!function_exists('getProfileData')) {
    function getProfileData($parliamentNumber = 0, $profileID = 0)
    {
        //i.e: getProfileData(11,1100011)
        // getProfileData(0,0);

        if ($profileID==0) {
            $current_parliament_data = Parliament::where('status', 1)->orderBy('parliament_number', 'desc')->first();
            $parliamentNumber = ($parliamentNumber > 0) ? $parliamentNumber : $current_parliament_data->parliament_number;
            $profile_data = V2Profile::where('constituencies.parliamentNumber', $parliamentNumber)
                ->leftJoin('constituencies', 'constituencies.number', '=', 'v2_profiles.constituencyNumber')
                ->where('v2_profiles.parliamentNumber', $parliamentNumber)
                ->where('v2_profiles.user_id','>',0)
                ->select('v2_profiles.*', 'constituencies.number as bangladesh_number', 'constituencies.name as voter_area_eng', 'constituencies.bn_name as voter_area_bng')
                ->orderBy('constituencyNumber', 'asc')
                ->groupBy('v2_profiles.profileID')
                ->get();
        } else {
            $current_parliament_data = Parliament::where('status', 1)->orderBy('parliament_number', 'desc')->first();
            $parliamentNumber = ($parliamentNumber > 0) ? $parliamentNumber : $current_parliament_data->parliament_number;
            $profile_data = V2Profile::where('constituencies.parliamentNumber', $parliamentNumber)
                ->leftJoin('constituencies', 'constituencies.number', '=', 'v2_profiles.constituencyNumber')
                ->where('v2_profiles.profileID', $profileID)
                ->where('v2_profiles.parliamentNumber', $parliamentNumber)
                ->select('v2_profiles.*', 'constituencies.number as bangladesh_number', 'constituencies.name as voter_area_eng', 'constituencies.bn_name as voter_area_bng')->first();
        }

        return $profile_data;
    }
}

// Bill And Legislation
if (!function_exists('getSubClause')) {
    function getSubClause($wheredata = ['bill_id' => null, 'parent' => null], $selected_sub_clause_id = null)
    {

        $sub_clauses = App\Model\BillAndLegislation::where('bill_id', $wheredata['bill_id'])->where('parent', $wheredata['parent'])->orderBy('sort', 'asc')->get();
        $html        = '<option value="">' . __('Select Clause') . '</option>';
        foreach ($sub_clauses as $key => $sub_clause) {
            if ($selected_sub_clause_id == $sub_clause->id) {
                $select = 'selected';
            } else {
                $select = '';
            }
            $html .= '<option value="' . $sub_clause['id'] . '" ' . @$select . '>' . $sub_clause['name_bn'] . '</option>';
        }
        return $html;
    }
}

// dont delete or edit this function anyone please
if (!function_exists('includeRouteFiles')) {

    if (!function_exists('getSubMenu')) {
        function getSubMenu($wheredata = ['parent' => null], $selected_sub_menu_id = null)
        {
            $sub_menus = App\Model\Menu::where('parent', $wheredata['parent'])->orderBy('sort', 'asc')->get();
            $html      = '<option value="">'.__('Select Sub Menu').'</option>';
            foreach ($sub_menus as $key => $sub_menu) {
                if ($selected_sub_menu_id == $sub_menu->id) {
                    $select = 'selected';
                } else {
                    $select = '';
                }
                $html .= '<option value="' . $sub_menu['id'] . '" ' . @$select . '>' . $sub_menu['name'] . ' ( ' . $sub_menu['module']['name'] . ' ) ' . '</option>';
            }
            return $html;
        }
    }

    function includeRouteFiles($folder)
    {
        try {
            $rdi = new recursiveDirectoryIterator($folder);
            $it  = new recursiveIteratorIterator($rdi);

            while ($it->valid()) {
                if (!$it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }
                $it->next();
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}

// For Frontend Menu
if (!function_exists('getSubMenuFrontend')) {
    function getSubMenuFrontend($wheredata = ['parent' => null], $selected_sub_menu_id = null)
    {
        $sub_menus = App\Model\Frontend\MenuFrontend::where('parent', $wheredata['parent'])->orderBy('sort', 'asc')->get();
        $html      = '<option value="">'.__('Select Sub Menu').'</option>';
        foreach ($sub_menus as $key => $sub_menu) {
            if ($selected_sub_menu_id == $sub_menu->id) {
                $select = 'selected';
            } else {
                $select = '';
            }
            $html .= '<option value="' . $sub_menu['id'] . '" ' . @$select . '>' . $sub_menu['name'] . ' ( ' . $sub_menu['name'] . ' ) ' . '</option>';
        }
        return $html;
    }
}

if (!function_exists('inner_permission')) {
    function inner_permission($permitted_route)
    {
        if (authInfo()->id == '1') {
            return true;
        }

        $user_role_array = authInfo()->user_role;
        if (count($user_role_array) == 0) {
            $user_role = [];
        } else {
            foreach ($user_role_array as $rolee) {
                $user_role[] = $rolee->role_id;
            }
        }

        $existpermission = MenuPermission::where('permitted_route', $permitted_route)->whereIn('role_id', @$user_role)->first();
        if ($existpermission) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('approvedStatus')) {
    function approvedStatus($value)
    {
        if ($value == 1) {
            $output = '<span class="badge badge-warning">' . __('Pending') . '</span>';
        } elseif ($value == 2) {
            $output = '<span class="badge badge-success">' . __('Approved') . '</span>';
        } elseif ($value == 3) {
            $output = '<span class="badge badge-danger">' . __('Rejected') . '</span>';
        } elseif ($value == 4) {
            $output = '<span class="badge badge-info">' . __('Acceptable') . '</span>';
        } elseif ($value == 5) {
            $output = '<span class="badge badge-primary">' . __('Acceptable with Correction') . '</span>';
        } else {
            $output = '<span class="badge badge-warning">' . __('Draft') . '</span>';
        }
        return $output;
    }
}

if (!function_exists('globalStatus')) {
    function globalStatus($type, $id, $without_badge = null)
    {
        $result = \DB::select("select * from global_status where status_type='" . $type . "' and status_id=" . $id);
        if (!empty($result)) {
            if (!is_null($without_badge)) {
                $output = array('status_name' => $result[0]->name_bn, 'status_color' => getColors($result[0]->status_color));
            } else {
                $output = '<span class="badge status_span badge-' . $result[0]->status_color . '">' . $result[0]->name_bn . '</span>';
            }
        }

        return $output;
    }
}

function getColors($color_class)
{
    $colors = array(
        'primary' => '#286090',
        'success' => '#449d44',
        'info' => '#31b0d5',
        'warning' => '#ec971f',
        'danger' => '#c9302c',
        'secondary' => '#6c757d',
        //'default"' =>'#6c757d',
        'basic' => '#cccccc'
    );
    if (!isset($colors[$color_class])) {
        return $colors['info'];
    } else {
        return $colors[$color_class];
    }
}

if (!function_exists('sorpermission')) {
    function sorpermission($route)
    {
        $user_role_array = authInfo()->user_role;
        if (count($user_role_array) == 0) {
            $user_role = [];
        } else {
            foreach ($user_role_array as $rolee) {
                $user_role[] = $rolee->role_id;
            }
        }

        if (in_array(1, $user_role)) {
            return true;
        } else {
            $mainmenuroute = MenuRoute::select('id')->where('route', $route)->first();
            if ($mainmenuroute != null) {
                $permission = MenuPermission::whereIn('role_id', $user_role)->where('permitted_route', $route)->first();
                if ($permission) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }
    }
}

if (!function_exists('maritalStatusDropdown')) {
    function maritalStatusDropdown($editStatus = null)
    {
        $meritals = array(1 => Lang::get('Unmarried'), 2 => Lang::get('Married'), 3 => Lang::get('Divorced'), 4 => Lang::get('Widowed'));

        $html = '<option value="">' . __('Select Marital Status') . '</option>';
        foreach ($meritals as $key => $merital) {
            if ($editStatus == $key) {
                $selected = 'selected';
            } else {
                $selected = (old('merital_status') == $key) ? 'selected' : '';
            }
            $html .= '<option ' . $selected . ' value="' . $key . '">' . $merital . '</option>';
        }

        return $html;
    }
}

if (!function_exists('maritalStatusView')) {
    function maritalStatusView($value)
    {
        if ($value == 1) {
            $output = __('Unmarried');
        } else if ($value == 2) {
            $output = __('Married');
        } else if ($value == 3) {
            $output = __('Divorced');
        } else if ($value == 4) {
            $output = __('Widowed');
        } else {
            $output = __('Unknown');
        }
        return $output;
    }
}

if (!function_exists('religionDropdown')) {
    function religionDropdown($editReligion = null)
    {
        $religions = array(1 => Lang::get('Islam'), 2 => Lang::get('Hindu'), 3 => Lang::get('Christian'), 4 => Lang::get('Buddhist'), 5 => Lang::get('Atheism'), 6 => Lang::get('Others'));
        $html      = '<option value="">' . __('Select Religion') . '</option>';
        foreach ($religions as $key => $religion) {
            if ($editReligion == $key) {
                $selected = 'selected';
            } else {
                $selected = (old('religion') == $key) ? 'selected' : '';
            }
            $html .= '<option ' . $selected . ' value="' . $key . '">' . $religion . '</option>';
        }

        return $html;
    }
}

if (!function_exists('religionView')) {
    function religionView($value)
    {
        if ($value == 1) {
            $output = __('Islam');
        } else if ($value == 2) {
            $output = __('Hindu');
        } else if ($value == 3) {
            $output = __('Christian');
        } else if ($value == 4) {
            $output = __('Buddhist');
        } else if ($value == 5) {
            $output = __('Atheism');
        } else {
            $output = __('Others');
        }
        return $output;
    }
}

if (!function_exists('statusDropdown')) {
    function statusDropdown($editStatus = null)
    {
        $datas = ['0' => __('Pending'), '1' => __('Approved'), '2' => __('Rejected')];
        $html  = '<option value="">' . __('Select Status') . '</option>';
        foreach ($datas as $key => $data) {
            if ($editStatus == $key) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $html .= '<option ' . $selected . ' value="' . $key . '">' . $data . '</option>';
        }
        return $html;
    }
}

if (!function_exists('activeStatusDropdown')) {
    function activeStatusDropdown($editStatus = null)
    {
        $datas = ['0' => __('Inactive'), '1' => __('Active')];
        $html  = '<option value="">' . __('Select Status') . '</option>';
        foreach ($datas as $key => $data) {
            if ($editStatus == $key) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $html .= '<option ' . $selected . ' value="' . $key . '">' . $data . '</option>';
        }
        return $html;
    }
}

if (!function_exists('designationDropdown')) {
    function designationDropdown($selectedId = null)
    {
        if (Schema::hasTable('designations')) {
            $designations = Designation::all();
            if (isset($designations) && count($designations) > 0) {
                $output = '<option value="">' . __('Select Designation') . '</option>';
                foreach ($designations as $key => $designation) {
                    if ($selectedId && $selectedId == $designation->id) {
                        $selected = 'selected';
                    } else {
                        $selected = '';
                        //$selected = (old('designation_id') == $key) ? 'selected' : '';
                    }
                    if (session()->get('language') == 'bn') {
                        $output .= '<option ' . $selected . ' value="' . $designation->id . '">' . $designation->name_bn . '</option>';
                    } else {
                        $output .= '<option ' . $selected . ' value="' . $designation->id . '">' . $designation->name . '</option>';
                    }
                }
            } else {
                $output = '<option value="">' . __(\Lang::get('No Data Available')) . '</option>';
            }
            return $output;
        }
    }
}

if (!function_exists('ministryDropdown')) {
    function ministryDropdown($selectedId = null)
    {
        if (Schema::hasTable('ministries')) {
            $ministry_list = Ministry::all();
            if (isset($ministry_list) && count($ministry_list) > 0) {
                $output = '<option value="">' . __('Select Ministry') . '</option>';
                foreach ($ministry_list as $key => $list) {
                    if ($selectedId && $selectedId == $list->id) {
                        $selected = 'selected';
                    } else {
                        $selected = '';
                    }
                    if (session()->get('language') == 'bn') {
                        $output .= '<option ' . $selected . ' value="' . $list->id . '">' . $list->name_bn . '</option>';
                    } else {
                        $output .= '<option ' . $selected . ' value="' . $list->id . '">' . $list->name . '</option>';
                    }
                }
            } else {
                $output = '<option value="">' . __(\Lang::get('No Data Available')) . '</option>';
            }
            return $output;
        }
    }
}

if (!function_exists('parliamentDropdown')) {
    function parliamentDropdown($selectedId = null)
    {
        if (Schema::hasTable('parliaments')) {
            $parliaments = Parliament::all();
            if (isset($parliaments) && count($parliaments) > 0) {
                $output = '<option value="">' . __('Select Parliament') . '</option>';
                foreach ($parliaments as $key => $parliament) {
                    if ($selectedId && $selectedId == $parliament->id) {
                        $selected = 'selected';
                    } else {
                        $selected = '';
                        //$selected = (old('parliament_id') == $key) ? 'selected' : '';
                    }
                    $output .= '<option ' . $selected . ' value="' . $parliament->id . '">' . digitDateLang($parliament->parliament_number) . '</option>';
                }
            } else {
                $output = '<option value="">' . __(\Lang::get('No Data Available')) . '</option>';
            }
            return $output;
        }
    }
}

if (!function_exists('sessionDropdown')) {
    function sessionDropdown($parliament_id = null)
    {
        if (!is_null($parliament_id)) {
            $session_list = ParliamentSession::where('parliament_id', $parliament_id);
        } else {
            $session_list = ParliamentSession::where('status', 1);
        }
        if (isset($session_list) && count($session_list) > 0) {
            $output = '<option value="0">' . __('Select Parliament Session') . '</option>';
            foreach ($session_list as $s) {

                $output .= '<option value="' . $s->id . '">' . digitDateLang($s->session_no) . '</option>';
            }
        } else {
            $output = '<option value="0">' . __('Select Parliament Session') . '</option>';
        }
        return $output;
    }
}

if (!function_exists('politicalPartiesDropdown')) {
    function politicalPartiesDropdown($selectedId = null)
    {
        if (Schema::hasTable('political_parties')) {
            $politicalParties = PoliticalParty::all();
            if (isset($politicalParties) && count($politicalParties) > 0) {
                $output = '<option value="">' . __('Select Political Party') . '</option>';
                foreach ($politicalParties as $key => $politicalParty) {
                    if ($selectedId && $selectedId == $politicalParty->id) {
                        $selected = 'selected';
                    } else {
                        $selected = (old('political_parties_id') == $key) ? 'selected' : '';
                    }
                    if (session()->get('language') == 'bn') {
                        $output .= '<option ' . $selected . ' value="' . $politicalParty->id . '">' . $politicalParty->name_bn . '</option>';
                    } else {
                        $output .= '<option ' . $selected . ' value="' . $politicalParty->id . '">' . $politicalParty->name . '</option>';
                    }
                }
            } else {
                $output = '<option value="">' . __(\Lang::get('No Data Available')) . '</option>';
            }
            return $output;
        }
    }
}

if (!function_exists('divisionDropdown')) {
    function divisionDropdown($selectedId = null)
    {
        if (Schema::hasTable('divisions')) {
            $divisions = Division::all();
            if (isset($divisions) && count($divisions) > 0) {
                $output = '<option value="">' . __('Select Division') . '</option>';
                foreach ($divisions as $key => $division) {
                    if ($selectedId && $selectedId == $division->id) {
                        $selected = 'selected';
                    } else {
                        $selected = '';
                    }
                    if (session()->get('language') == 'bn') {
                        $output .= '<option ' . $selected . ' value="' . $division->id . '">' . $division->bn_name . '</option>';
                    } else {
                        $output .= '<option ' . $selected . ' value="' . $division->id . '">' . $division->name . '</option>';
                    }
                }
            } else {
                $output = '<option value="">' . __(\Lang::get('No Data Available')) . '</option>';
            }
            return $output;
        }
    }
}
if (!function_exists('districtDropdown')) {
    function districtDropdown($selectedId = null)
    {
        if (Schema::hasTable('districts')) {
            $districts = District::all();
            if (isset($districts) && count($districts) > 0) {
                $output = '<option value="">' . __('Select District') . '</option>';
                foreach ($districts as $key => $district) {
                    if ($selectedId && $selectedId == $district->id) {
                        $selected = 'selected';
                    } else {
                        $selected = (old('birth_district_id') == $key) ? 'selected' : '';
                    }
                    if (session()->get('language') == 'bn') {
                        $output .= '<option ' . $selected . ' value="' . $district->id . '">' . $district->bn_name . '</option>';
                    } else {
                        $output .= '<option ' . $selected . ' value="' . $district->id . '">' . $district->name . '</option>';
                    }
                }
            } else {
                $output = '<option value="">' . __(\Lang::get('No Data Available')) . '</option>';
            }
            return $output;
        }
    }
}

if (!function_exists('areaDropdown')) {
    function areaDropdown($selectedId = null)
    {
        if (Schema::hasTable('areas')) {
            $areas = Area::all();
            if (isset($areas) && count($areas) > 0) {
                $output = '<option value="">' . __('Select Area') . '</option>';
                foreach ($areas as $key => $area) {
                    if ($selectedId && $selectedId == $area->id) {
                        $selected = 'selected';
                    } else {
                        $selected = '';
                    }
                    if (session()->get('language') == 'bn') {
                        $output .= '<option ' . $selected . ' value="' . $area->id . '">' . $area->name_bn . '</option>';
                    } else {
                        $output .= '<option ' . $selected . ' value="' . $area->id . '">' . $area->name . '</option>';
                    }
                }
            } else {
                $output = '<option value="">' . __(\Lang::get('No Data Available')) . '</option>';
            }
            return $output;
        }
    }
}

if (!function_exists('constituenciesDropdown')) {
    function constituenciesDropdown()
    {
        if (Schema::hasTable('constituencies')) {
            $constituencies = Constituency::all();
            if (isset($constituencies) && count($constituencies) > 0) {
                $output = '<option value="">' . __('Select Constituency') . '</option>';
                foreach ($constituencies as $key => $constituency) {
                    $selected = (old('constituency_id') == $key) ? 'selected' : '';
                    $output .= '<option value="' . $constituency->id . '"' . $selected . '>' . $constituency->name . '</option>';
                }
            } else {
                $output = '<option value="">' . __(\Lang::get('No Data Available')) . '</option>';
            }
            return $output;
        }
    }
}
if (!function_exists('itemsDropdown')) {
    function itemsDropdown($type, $date = null, $ministry_id = null)
    {
        $output = '';
        if ($type == 'ministry') {
            $ministry_list = \DB::select("SELECT c.*,m.name_bn as ministry_name FROM circulars c left join ministries m on m.id = c.ministry_id where c.date='" . $date . "'");

            if (isApi()) {
                return $ministry_list;
            }
            if (isset($ministry_list) && count($ministry_list) > 0) {
                $output = '<option value="">' . __('Select Ministry') . '</option>';
                foreach ($ministry_list as $key => $m) {
                    $selected = (old('ministry_id') == $key) ? 'selected' : '';
                    $output .= '<option value="' . $m->ministry_id . '"' . $selected . '>' . $m->ministry_name . '</option>';
                }
            } else {
                $output = '<option value="">' . __(\Lang::get('No Data Available')) . '</option>';
            }
        }
        if ($type == 'wing') {
            //$wing_list = \DB::select("SELECT m.*, mw.id as wing_id, mw.name_bn as wing_name FROM ministries m left join ministry_wings mw on m.id = mw.ministry_id where m.id=" . $ministry_id);
            //select id,name_eng, name_bn from ministry_wings where id IN(2,5)
            //select id,name_eng, name_bn from ministry_wings where id IN(select wing_id from circulars where ministry_id=20 and date='2021-09-20')
            //select mw.id,mw.name_eng, mw.name_bn from ministry_wings mw inner join circulars c on c.ministry_id = mw.ministry_id where mw.ministry_id=20 and c.date='2021-09-20'
            if($date!=''){
                $wing_list = \DB::select("select mw.id,mw.name_eng, mw.name_bn from ministry_wings mw inner join circulars c on c.ministry_id = mw.ministry_id where mw.ministry_id=".$ministry_id." and c.date='".$date."'");
            }else{
                $wing_list = \DB::select("SELECT * FROM ministry_wings where ministry_id=" . $ministry_id);
            }

            if (isApi()) {
                return $wing_list;
            }
            if (isset($wing_list) && count($wing_list) > 0) {
                $output = '<option value="">' . __('Select Wing') . '</option>';
                foreach ($wing_list as $key => $m) {
                    $selected = (old('id') == $key) ? 'selected' : '';
                    $output .= '<option value="' . $m->id . '"' . $selected . '>' . $m->name_bn . '</option>';
                }
            } else {
                $output = '<option value="">' . __(\Lang::get('No Data Available')) . '</option>';
            }
        }
        if ($type == 'billLegislation') {
            $billLegislation_list = \App\Model\BillAndLegislationTitle::where("ministry_id", $ministry_id)->get();

            if (isApi()) {
                return $billLegislation_list;
            }
            if (isset($billLegislation_list) && count($billLegislation_list) > 0) {
                $output = '<option selected value="0">' . __('Select Bill and Legislation') . '</option>';
                foreach ($billLegislation_list as $key => $bill) {
                    $output .= '<option value="' . $bill->id . '">' . $bill->name_bn . '</option>';
                }         
   
            } else {
                $output = '<option value="">' . __(\Lang::get('No Data Available')) . '</option>';
            }
        }
        return $output;
    }
}

if (!function_exists('activeStatus')) {
    function activeStatus($value)
    {
        if ($value == 1) {
            $output = '<span class="badge badge-success">' . __('Active') . '</span>';
        } else {
            $output = '<span class="badge badge-danger">' . __('Inactive') . '</span>';
        }
        return $output;
    }
}

if (!function_exists('OTPStatus')) {
    function OTPStatus($value)
    {
        if ($value == 1) {
            $output = '<span class="badge badge-success">' . __('Active') . '</span>';
        } else {
            $output = '<span class="badge badge-danger">' . __('Inactive') . '</span>';
        }
        return $output;
    }
}

if (!function_exists('digitDateLang')) {
    function digitDateLang($number)
    {
        $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "AM", "PM", "am", "pm", "cusec", "litre", "horse", "Jan", "Feb", "Mar", "Apr", "May", "Jun", 'Jul', "Aug", "Sep", "Oct", "Nov", "Dec", "January", "February", "March", "April", "May", "June", 'July', "August", "September", "October", "November", "December", "Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Weekend", "day", "week", "month", "year");
        $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০", "এ.এম", "পি.এম", "এ.এম", "পি.এম", "কিউসেক", "লিটার/সে.", "অশ্বশক্তি", "জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "অগাস্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর", "জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "অগাস্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর", "শনিবার", "রবিবার", "সোমবার", "মঙ্গলবার", "বুধবার", "বৃহস্পতিবার", "শুক্রবার", "সাপ্তাহিক ছুটি", "দিন", "সপ্তাহ", "মাস", "বছর");

        if (Session::get('language') == 'bn') {
            return str_replace($en, $bn, $number);
        } else {
            return str_replace($bn, $en, $number);
        }
    }
}

if (!function_exists('nanoDateFormat')) {
    function nanoDateFormat($data, $format = null, $am_pm = false)
    {
        if ($data != '') {
            if ($am_pm) {
                return (!is_null($format)) ? date($format . ' | h:i A', strtotime($data)) : date('d M Y | h:i A', strtotime($data));
            } else {
                //return ( !is_null( $format ) ) ? date( $format, strtotime( $data ) ) : date( 'd M Y', strtotime( $data ) );
                return (!is_null($format)) ? date('d M Y', strtotime($data)) : date('d M Y', strtotime($data));
            }
        }
    }
}

if (!function_exists('statusDropdownView')) {
    function statusDropdownView($value)
    {
        if ($value == 0) {
            $output = '<span class="badge badge-warning">' . __('Pending') . '</span>';
        } elseif ($value == 1) {
            $output = '<span class="badge badge-success">' . __('Approved') . '</span>';
        } else {
            $output = '<span class="badge badge-danger">' . __('Rejected') . '</span>';
        }
        return $output;
    }
}

if (!function_exists('subClauseDropdown')) {
    function subClauseDropdown($id)
    {
        if (Schema::hasTable('parliament_bill_sub_clauses')) {
            $subClauses = ParliamentBillSubClause::where('parliament_bill_clause_id', $id)->get();
            if (isset($subClauses) && count($subClauses) > 0) {
                $output = '<option value="">' . __('Select Sub Clause') . '</option>';
                foreach ($subClauses as $key => $subClause) {
                    $output .= '<option value="' . $subClause->id . '">Sub clause - ' . $subClause->number . '</option>';
                }
            } else {
                $output = '<option value="">' . __(\Lang::get('No Data Available')) . '</option>';
            }
            return $output;
        }
    }
}

if (!function_exists('billTopicList')) {
    function billTopicList($rule = null)
    {
        if (!is_null($rule) && $rule == 78) {
            return array(
                array('id' => 0, 'name' => 'সংশোধনী উত্থাপন নির্বাচন করুন'),
                array('id' => 1, 'name' => Lang::get('Promoting Bills for Public Opinion')),
                array('id' => 2, 'name' => Lang::get('Sending Bills to the Standing/Assessment Committee')),
                array('id' => 3, 'name' => Lang::get('Adding Names to The Assessment Committee')),
                array('id' => 4, 'name' => Lang::get('Canceling Names from The Assessment Committee')),
                array('id' => 5, 'name' => Lang::get('Exchanging Names in The Assessment Committee')),
            );
        } else if (!is_null($rule) && $rule == 82) {
            return array(
                array('id' => 0, 'name' => 'বিলের বিধানসমূহে সংশোধনীর নোটিশ নির্বাচন করুন'),
                array('id' => 1, 'name' => Lang::get('দফার পরিবর্তে দফা প্রতিস্থাপন')),
                array('id' => 2, 'name' => Lang::get('নতুন দফা সংযোজন')),
                array('id' => 3, 'name' => Lang::get('শর্ত-দফা সংযোজন')),
                array('id' => 4, 'name' => Lang::get('শব্দটি/শব্দাবলী বর্জন')),
                array('id' => 5, 'name' => Lang::get('শব্দাবলী সন্নিবেশ')),
                array('id' => 6, 'name' => Lang::get('প্যারার পরিবর্তে প্যারা প্রতিস্থাপন')),
                array('id' => 7, 'name' => Lang::get('শব্দাবলী বর্জন এবং শব্দাবলীর পরিবর্তে নতুন শব্দাবলী প্রতিস্থাপন')),
            );
        } else {
            return array();
        }
    }
}

if (!function_exists('userTypeList')) {
    function userTypeList()
    {
        return array(
            array('id' => 'mp', 'name' => Lang::get('MP')),
            array('id' => 'staff', 'name' => Lang::get('Staff')),
            array('id' => 'speaker', 'name' => Lang::get('Speaker')),
            array('id' => 'admin', 'name' => Lang::get('Admin')),
        );
    }
}

if (!function_exists('comboList')) {
    function comboList($type = null, $rule_number = null)
    {
        $output = [];
        if (!is_null($type)) {
            if ($type === 'question_types') {
                if (!is_null($rule_number) && $rule_number == 42) {
                    if(isApi()){
                        $output = array(
                            array('id' => 0, 'name' => Lang::get('Non Star Question')),
                            array('id' => 1, 'name' => Lang::get('Star Question')),
                            array('id' => 2, 'name' => Lang::get('Prime Minister Question')),
                        );
                    }
                    else{
                        $output = array(
                            array('id' => 0, 'name' => Lang::get('Non Star Question')),
                            array('id' => 1, 'name' => Lang::get('Star Question')),
                        );
                    }
                    
                } else {
                    $output = array(
                        array('id' => 0, 'name' => Lang::get('Non Star Question')),
                        array('id' => 1, 'name' => Lang::get('Star Question')),
                    );
                }

                $output = array_sort($output, 'id', SORT_ASC);
            } else if ($type === 'parliament_sessions') {
                $output = array(
                    array('id' => 0, 'name' => Lang::get('Upcoming Session')),
                    array('id' => 1, 'name' => Lang::get('Current Session')),
                );

                $output = array_sort($output, 'id', SORT_DESC);
            } else if ($type === 'committee') {
                $output = array(
                    array('id' => 0, 'name' => 'কমিটির নাম নির্বাচন করুন'),
                    array('id' => 1, 'name' => 'স্থায়ী কমিটি'),
                    array('id' => 2, 'name' => 'বাছাই কমিটি'),
                );
                $output = array_sort($output, 'id', SORT_ASC);
            }
        }
        return $output;
    }
}

function array_sort($array, $on, $order = SORT_ASC)
{
    $new_array      = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

if (!function_exists('csvToArray')) {
    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        $header = null;
        $data   = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        return $data;
    }
}

if (!function_exists('accommodationApplicationTypeDropdown')) {
    function accommodationApplicationTypeDropdown($selectedId = null)
    {
        if (Schema::hasTable('accommodation_application_types')) {
            $acc_app_types = AccommodationApplicationType::all();
            if (isset($acc_app_types) && count($acc_app_types) > 0) {
                $output = '<option value="">' . __('Select AccommodationApplicationType') . '</option>';
                foreach ($acc_app_types as $key => $acc_app_type) {
                    if ($selectedId && $selectedId == $acc_app_type->id) {
                        $selected = 'selected';
                    } else {
                        $selected = '';
                    }
                    $output .= '<option ' . $selected . ' value="' . $acc_app_type->id . '">' . $acc_app_type->type_name . '</option>';
                }
            } else {
                $output = '<option value="">' . __(\Lang::get('No Data Available')) . '</option>';
            }
            return $output;
        }
    }
}

if (!function_exists('fileCategoryDropdown')) {
    function fileCategoryDropdown($selectedId = null)
    {
        if (Schema::hasTable('file_categories')) {

            $auth_id = Auth::id();
            if (authInfo()->usertype == 'ps') {
                $mp_user_id = MpPs::select('mp_user_id')->where('ps_user_id', authInfo()->id)->first();
                if ($mp_user_id) {
                    $category_list = FileCategory::where('created_by', authInfo()->id)
                        ->orWhere('created_by', $mp_user_id->mp_user_id)->get();
                }
            } else if (authInfo()->usertype != 'ps') {
                $ps_user_id = MpPs::select('ps_user_id')->where('mp_user_id', authInfo()->id)->first();
                if ($ps_user_id) {
                    $category_list = FileCategory::where('created_by', authInfo()->id)
                        ->orWhere('created_by', $ps_user_id->ps_user_id)->get();
                } else {
                    $category_list = FileCategory::where('created_by', authInfo()->id)->get();
                }
            }

            // $category_list = FileCategory::where('mp_id',$auth_id)->get();
            if (isset($category_list) && count($category_list) > 0) {
                $output = '<option value="">' . __('Select Category') . '</option>';
                foreach ($category_list as $key => $list) {
                    if ($selectedId == $list->id) {
                        $selected = 'selected';
                    } else {
                        $selected = '';
                    }
                    if (session()->get('language') == 'bn') {
                        $output .= '<option ' . $selected . ' value="' . $list->id . '">' . $list->category_name_bn . '</option>';
                    } else {
                        $output .= '<option ' . $selected . ' value="' . $list->id . '">' . $list->category_name_en . '</option>';
                    }
                }
            } else {
                $output = '<option value="">' . __(\Lang::get('No Data Available')) . '</option>';
            }
            return $output;
        }
    }
}

if (!function_exists('proggaponCategoryDropdown')) {
    function proggaponCategoryDropdown($selectedId = null)
    {
        if (Schema::hasTable('proggapon_categories')) {
            $category_list = ProggaponCategory::all();
            if (isset($category_list) && count($category_list) > 0) {
                $output = '<option value="">' . __('Select the Proggapon Category') . '</option>';
                foreach ($category_list as $key => $list) {
                    if ($selectedId == $list->id) {
                        $selected = 'selected';
                    } else {
                        $selected = '';
                    }
                    if (session()->get('language') == 'bn') {
                        $output .= '<option ' . $selected . ' value="' . $list->id . '">' . $list->category_name_bn . '</option>';
                    } else {
                        $output .= '<option ' . $selected . ' value="' . $list->id . '">' . $list->category_name_en . '</option>';
                    }
                }
            } else {
                $output = '<option value="">' . __(\Lang::get('No Data Available')) . '</option>';
            }
            return $output;
        }
    }
}

if (!function_exists('arrayToimage')) {
    function arrayToimage($arr = null)
    {
        //return "<img class='profile-user-img img-responsive img-circle' src=" . $arr . " alt=\"profile image\" />";
        return "<img class='profile-user-img img-responsive img-circle' src=" . asset('/public/backend/profile/' . $arr) . " alt=\"profile image\" />";
    }
}

if (!function_exists('bloodGroupList')) {
    function bloodGroupList()
    {
        return array(0 => array('id' => 1, 'name_eng' => 'A Positive', 'name_bng' => 'এ পজিটিভ',), 1 => array('id' => 2, 'name_eng' => 'A Negative', 'name_bng' => 'এ নেগেটিভ',), 2 => array('id' => 3, 'name_eng' => 'B Positive', 'name_bng' => 'বি পজিটিভ',), 3 => array('id' => 4, 'name_eng' => 'B Negative', 'name_bng' => 'বি নেগেটিভ',), 4 => array('id' => 5, 'name_eng' => 'AB Positive', 'name_bng' => 'এবি পজিটিভ',), 5 => array('id' => 6, 'name_eng' => 'AB Negative', 'name_bng' => 'এবি নেগেটিভ',), 6 => array('id' => 7, 'name_eng' => 'O Positive', 'name_bng' => 'ও পজিটিভ',), 7 => array('id' => 8, 'name_eng' => 'O Negative', 'name_bng' => 'ও নেগেটিভ',),);
    }
}

if (!function_exists('getCurrentSession')) {
    function getCurrentSession(){
        $current_session = \DB::select('select * from parliament_sessions where DATE(NOW()) between date_from and date_to and status = 1 and parliament_sessions.deleted_at is null order by date_to desc limit 1');
        if(count($current_session)>0){
            return $current_session[0];
        }
    }
}

if (!function_exists('getCurrentParliament')) {
    function getCurrentParliament(){
        $current_parliament = \DB::select('select * from parliaments where DATE(NOW()) between date_from and date_to and status = 1 and parliaments.deleted_at is null order by date_to desc limit 1');
        if(count($current_parliament)>0){
            return $current_parliament[0];
        }
    }
}

/* PRP stuff */
if (!function_exists('prpLogin')) {
    function prpLogin(){
        //$prp_secret = \Session::get('prpSecret');
        //if($prp_secret==null){
            $endpoint  = "https://prp.parliament.gov.bd/ext/employee-records-api";
            $action   = "getAuthenticated";
            $response = Http::withHeaders([
                'alias' => 'nano',
                'secret' => '8nzqr5PoFz1W#5y3F@88OG254aJpa9rJ7DUvXWAfiy8Di9mJnRh9weBwNN31rlSSD',
            ])->get($endpoint, [
                'action' => $action
            ]);

            $statusCode = $response->getStatusCode();
            $content    = $response->getBody();
            $prp_login_details = json_decode($content,true);
            if($prp_login_details['responseCode']==200){
                $prpStuff = collect([
                    'alias'=>'nano',
                    'secret'=>'8nzqr5PoFz1W#5y3F@88OG254aJpa9rJ7DUvXWAfiy8Di9mJnRh9weBwNN31rlSSD',
                    'token'=>$prp_login_details['payload']['token']
                ]);
                Session::put('prpSecret', $prpStuff->toArray());
            }
            return $prp_login_details['responseCode'];
        //}
       // return $prp_login_details['responseCode'];

    }
}

