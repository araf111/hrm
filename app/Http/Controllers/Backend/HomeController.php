<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Model\Parliament;
use App\Model\ParliamentSession;
use App\Model\ParliamentRule;
use App\Model\OrderOfDay;
use App\Model\Mpattendance;
use App\Model\MpLeaveApplication;
use App\Model\Notice;
use App\Model\Appointment;
use App\Model\CommitteeMeeting;
use App\Model\Circular;
use App\Pull;
use App\PullQuestion;
use App\PullQuestionRealtion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use DataTables;
use PDF;
use Active;
use App\Model\LoginActivity;
use App\Model\RouteLog;
use App\Model\PoleAnswer;
use App\Model\UserRole;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['usertype'] = authInfo()->usertype;
        $data['parliament_list'] = Parliament::where('status', 1)->orderby('id', 'desc')->get();

        //check if the loggedin user in the role_ids 
        $user_roles = UserRole::where('user_id', authInfo()->id)->get()->pluck('role_id')->toArray();
        $user_roles = (count($user_roles) > 0) ? implode(',', $user_roles) : '';
        //list all poles where the role_id exists in the pulls(pole) table
        $todayDate = date('Y-m-d', strtotime(Carbon::today()));
        $data['pole_list'] = Pull::where('status', 1)
            ->where('fromDate', '<=', $todayDate)
            ->where('toDate', '>=', $todayDate)
            ->whereRaw("FIND_IN_SET(?, user_role) > 0", [$user_roles])->orderby('id', 'desc')->get();

        if (!empty($data['parliament_list'])) {
            foreach ($data['parliament_list'] as $d) {
                $d->parliament_number_bn = \Lang::get($d->parliament_number);
            }
        }
        $rule_list                   = ParliamentRule::orderBy('id', 'desc')->get();
        foreach ($rule_list as $r) {
            $r->rule_name = \Lang::get('Rule') . ' ' . digitDateLang($r->rule_number);
        }

        $collection  = collect($rule_list);
        $partial_result      = ceil($collection->count() / 6);
        $rule_list = $collection->chunk($partial_result);
        $data['allRules'] = $rule_list;
        return view('backend.home', $data);
    }

    public function mpDashboardSummary()
    {
        $rule_list                   = ParliamentRule::orderBy('id', 'desc')->get();
        foreach ($rule_list as $r) {
            $r->rule_name = \Lang::get('Rule') . digitDateLang($r->rule_number);
        }
        $data['allRules'] = $rule_list;
    }

    public function getPoles($id)
    {
        $active_pole = Pull::find($id);
        //$all_poles = Pull::where('status',1)->get();
        $question_list = PullQuestionRealtion::where('pull_question_realtions.p_id', $active_pole->id)
            ->where('pull_questions.status', 1)
            ->leftJoin('pull_questions', 'pull_questions.id', '=', 'pull_question_realtions.q_id')
            ->select('pull_question_realtions.q_id', 'pull_questions.question as question_name')
            ->get();
        $data['question_list'] = $question_list;
        $data['pole_id'] = $active_pole->id;
        return view('backend.dashboard.pole_listing', $data);
    }

    public function savePole(Request $request)
    {
        //dd($request->all());
        if (isset($request->answer) && $request->answer !== '') {
            $pole_answer = explode('_', $request->answer);
            $question = $pole_answer[0];
            $answer = $pole_answer[1];
            $user_id = authInfo()->id;
            $pole_id = $request->pole_id;

            //check if this user already vote for this pole
            $existing_pole = PoleAnswer::where('pole_id', $pole_id)
                ->where('question_id', $question)
                ->where('user_id', $user_id)
                ->first();

            //dd($existing_pole);

            if (!empty($existing_pole)) {
                return json_encode(array('status' => false, 'message' => \Lang::get('You have already voted')));
            } else {
                $user_answer = new PoleAnswer();
                $user_answer->pole_id = $pole_id;
                $user_answer->question_id = $question;
                $user_answer->answer_id = $answer;
                $user_answer->user_id = $user_id;
                $user_answer->save();
                return json_encode(array('status' => true, 'message' => \Lang::get('Data Saved successfully')));
            }
        }
    }

    public function getSummary($session_id = null, $module = null)
    {

        $start = '';
        $end = '';
        if (is_null($session_id)) {
            echo json_encode(array('status' => false, 'data' => []));
        } else {
            if ($module == 'summary') {
                if (authInfo()->usertype == 'mp') {
                    $data = [];
                    if ($session_id !== '' && $session_id > 0) {
                        $session_data = ParliamentSession::where('parliament_sessions.id', $session_id)
                            ->leftJoin('parliaments', 'parliaments.id', '=', 'parliament_sessions.parliament_id')
                            ->select('parliament_sessions.*', 'parliaments.parliament_number')
                            ->first();
                        if (isset($session_data->date_from) && isset($session_data->date_to)) {
                            $start = date('Y-m-d', strtotime($session_data->date_from));
                            $end = date('Y-m-d', strtotime($session_data->date_to));
                        }
                    } else {
                        //list all current session's record
                        $session_data = ParliamentSession::where('parliament_sessions.status', 1)
                            ->leftJoin('parliaments', 'parliaments.id', '=', 'parliament_sessions.parliament_id')
                            ->select('parliament_sessions.*', 'parliaments.parliament_number')
                            ->first();
                        if (isset($session_data->date_from) && isset($session_data->date_to)) {
                            $start = date('Y-m-d', strtotime($session_data->date_from));
                            $end = date('Y-m-d', strtotime($session_data->date_to));
                        }
                    }

                    $order_of_days = OrderOfDay::whereBetween('order_date', [$start, $end])->orderBy('id', 'desc')->first();

                    $data['order_of_days'] = (isset($order_of_days->order_document)) ? '<a  href="javascript:void(0);" onclick="any_download_file(\'' . url('/public/backend/attachment') . '/' . $order_of_days->order_document . '\')">' . \Lang::get("Download") . '</a>' : '';
                    $data['total_attendance'] = Mpattendance::whereBetween('date', [$start, $end])
                        ->where('mp_id', authInfo()->id)
                        ->orderBy('id', 'desc')->count();
                    $data['total_attendance'] = (!empty($data['total_attendance'])) ? digitDateLang($data['total_attendance']) : 0;
                    $data['total_leave'] = MpLeaveApplication::whereBetween('from_date', [$start, $end])
                        ->where('application_for', authInfo()->id)
                        ->where('status', 2) // status:2 = approved
                        ->orderBy('id', 'desc')->count();
                    $data['total_leave'] = (!empty($data['total_leave'])) ? digitDateLang($data['total_leave']) : 0;
                    $mp_leaves = MpLeaveApplication::whereBetween('from_date', [$start, $end])
                        ->where('application_for', authInfo()->id)
                        //->where('status',2) // status:2 = approved
                        ->orderBy('id', 'desc')->take(5)->get();
                    /* $mp_appointments = Appointment::whereBetween('date', [$start, $end])
                            ->where('created_by', authInfo()->id)
                            ->orderBy('id', 'desc')->take(5)->get(); */
                    $mp_appointments = Appointment::where('created_by', authInfo()->id)
                        ->orderBy('id', 'desc')->take(5)->get();
                    $mp_leaves_list = '<table class="table table-sm table-bordered table-striped mb-4">
                            <thead>
                                <tr>
                                    <th>' . \Lang::get('From') . '</th>
                                    <th>' . \Lang::get('To') . '</th>
                                    <th width="10%">' . \Lang::get('Total') . '</th>
                                    <th>' . \Lang::get('Subject') . '</th>
                                    <th>' . \Lang::get('Status') . '</th>
                                </tr>
                            </thead>
                        <tbody class="sortable">';
                    if (count($mp_leaves) > 0) {
                        foreach ($mp_leaves as $m) {
                            $to_date = Carbon::parse($m->to_date);
                            $from_date = Carbon::parse($m->from_date);
                            $total_days = $to_date->diffInDays($from_date);
                            if ($m->status == 1) {
                                $m->leave_status = '<span class=""> <i class="fa  fa-hourglass"></i></span>';
                            } else if ($m->status == 2) {
                                $m->leave_status = '<span class=""> <i class="fa fa-check"></i></span>';
                            } else if ($m->status == 3) {
                                $m->leave_status = '<span class=""> <i class="fa fa-times"></i></span>';
                            } else {
                                $m->leave_status = '<span class=""> <i class="fa fa-eye"></i></span>';
                            }

                            $mp_leaves_list .= '<tr>
                                    <td>' . digitDateLang(nanoDateFormat($m->from_date)) . '</td>
                                    <td>' . digitDateLang(nanoDateFormat($m->to_date)) . '</td>
                                    <td>' . digitDateLang($total_days) . '</td>
                                    <td>' . $m->note . '</td>
                                    <td style="text-align:center;">' . $m->leave_status . '</td>
                                </tr>';
                        }
                    }
                    $mp_leaves_list .= '</tbody></table>';
                    $data['mp_leaves'] = $mp_leaves_list;

                    //mp appointment list
                    $mp_appointment_list = '<table class="table table-sm table-bordered table-striped mb-4">
                            <thead>
                                <tr>
                                    <th>' . \Lang::get('Date') . '</th>
                                    <th>' . \Lang::get('Topic') . '</th>
                                    <th>' . \Lang::get('From') . '</th>
                                    <th>' . \Lang::get('To') . '</th>
                                </tr>
                            </thead>
                        <tbody class="sortable">';
                    if (count($mp_appointments) > 0) {
                        foreach ($mp_appointments as $m) {
                            if ($m->status == 1) {
                                $m->appointment_status = '<span class=""> <i class="fa  fa-hourglass"></i></span>';
                            } else if ($m->status == 2) {
                                $m->appointment_status = '<span class=""> <i class="fa fa-check"></i></span>';
                            } else if ($m->status == 3) {
                                $m->appointment_status = '<span class=""> <i class="fa fa-times"></i></span>';
                            } else {
                                $m->appointment_status = '<span class=""> <i class="fa fa-eye"></i></span>';
                            }

                            $mp_appointment_list .= '<tr>
                                    <td>' . digitDateLang(nanoDateFormat($m->date)) . '</td>
                                    <td>' . $m->topics . '</td>
                                    <td>' . digitDateLang($m->time_from) . '</td>
                                    <td>' . digitDateLang($m->time_to) . '</td>
                                    <td style="text-align:center;">' . $m->appointment_status . '</td>
                                </tr>';
                        }
                    }
                    $mp_appointment_list .= '</tbody></table>';
                    $data['mp_appointments'] = $mp_appointment_list;
                    //for notice bar graph
                    //SELECT notice_from, rule_number, count(id) as total_notices FROM `notices` where notice_from=2 and status>0 and created_at between '2021-05-01' and '2021-08-05' group by rule_number

                    //rule_number and statuswise summary for donut chart
                    //SELECT notice_from, rule_number, status, count(id) as total_notices FROM `notices` where notice_from=2 and created_at between '2021-05-01' and '2021-08-05' group by rule_number,status

                    $data['notice_bar_chart'] = Notice::groupBy('rule_number')->select('rule_number', DB::raw('count(*) as total_notices'))
                        ->whereBetween('created_at', [$start, $end])
                        ->where('notice_from', authInfo()->id)
                        ->get();
                    if (count($data['notice_bar_chart']) > 0) {
                        foreach ($data['notice_bar_chart'] as $b) {
                            $b->rule_number = digitDateLang($b->rule_number);
                            //$b->total_notices = digitDateLang($b->total_notices);
                        }
                    }

                    $data['notice_donut_chart'] = Notice::groupBy(array('rule_number', 'status'))->select('rule_number', 'status', DB::raw('count(*) as total_notices'))
                        ->whereBetween('created_at', [$start, $end])
                        ->where('notice_from', authInfo()->id)
                        ->get();

                    if (count($data['notice_donut_chart']) > 0) {
                        $data['donut_list'] = [];
                        $data['notice_donut_chart']  = $this->group_by("rule_number", json_decode(json_encode($data['notice_donut_chart'], true), true));
                        foreach ($data['notice_donut_chart'] as $key => $val) {
                            foreach ($data['notice_donut_chart'][$key] as $k => $v) {
                                $data['notice_donut_chart'][$key][$k]['status_data'] = globalStatus('notice', $data['notice_donut_chart'][$key][$k]['status'], 1);
                            }
                        }
                        $data['donut_list'][] = $data['notice_donut_chart'];
                    }
                } else if (authInfo()->usertype == 'admin') {
                    $data = [];
                    if ($session_id !== '' && $session_id > 0) {
                        $session_data = ParliamentSession::where('parliament_sessions.id', $session_id)
                            ->leftJoin('parliaments', 'parliaments.id', '=', 'parliament_sessions.parliament_id')
                            ->select('parliament_sessions.*', 'parliaments.parliament_number')
                            ->first();
                        if (isset($session_data->date_from) && isset($session_data->date_to)) {
                            $start = date('Y-m-d', strtotime($session_data->date_from));
                            $end = date('Y-m-d', strtotime($session_data->date_to));
                        }
                    } else {
                        //list all current session's record
                        $session_data = ParliamentSession::where('parliament_sessions.status', 1)
                            ->leftJoin('parliaments', 'parliaments.id', '=', 'parliament_sessions.parliament_id')
                            ->select('parliament_sessions.*', 'parliaments.parliament_number')
                            ->first();
                        if (isset($session_data->date_from) && isset($session_data->date_to)) {
                            $start = date('Y-m-d', strtotime($session_data->date_from));
                            $end = date('Y-m-d', strtotime($session_data->date_to));
                        }
                    }

                    $order_of_days = OrderOfDay::whereBetween('order_date', [$start, $end])->orderBy('id', 'desc')->first();

                    $data['order_of_days'] = (isset($order_of_days->order_document)) ? '<a  href="javascript:void(0);" onclick="any_download_file(\'' . url('/public/backend/attachment') . '/' . $order_of_days->order_document . '\')">' . \Lang::get("Download") . '</a>' : '';
                    //$data['order_of_days'] = (isset($order_of_days->order_document) && file_exists(url('/public/backend/attachment') . '/' . $order_of_days->order_document)) ? '<a href="' . url('/public/backend/attachment') . '/' . $order_of_days->order_document . '">'.\Lang::get("Download").'</a>' : \Lang::get('No File Added');
                    $data['total_attendance'] = Mpattendance::whereBetween('date', [$start, $end])
                        //->where('mp_id', authInfo()->id)
                        ->orderBy('id', 'desc')->count();
                    $data['total_attendance'] = (!empty($data['total_attendance'])) ? digitDateLang($data['total_attendance']) : 0;
                    $data['total_leave'] = MpLeaveApplication::whereBetween('from_date', [$start, $end])
                        //->where('application_for', authInfo()->id)
                        ->where('status', 2) // status:2 = approved
                        ->orderBy('id', 'desc')->count();
                    $data['total_leave'] = (!empty($data['total_leave'])) ? digitDateLang($data['total_leave']) : 0;
                    $mp_leaves = MpLeaveApplication::whereBetween('from_date', [$start, $end])
                        //->where('application_for', authInfo()->id)
                        //->where('status',2) // status:2 = approved
                        ->orderBy('id', 'desc')->take(5)->get();
                    /* $mp_appointments = Appointment::whereBetween('date', [$start, $end])
                            ->where('created_by', authInfo()->id)
                            ->orderBy('id', 'desc')->take(5)->get(); */
                    $mp_appointments = Appointment::orderBy('id', 'desc')->take(5)->get();
                    $mp_leaves_list = '<table class="table table-sm table-bordered table-striped mb-4">
                            <thead>
                                <tr>
                                    <th>' . \Lang::get('From') . '</th>
                                    <th>' . \Lang::get('To') . '</th>
                                    <th width="10%">' . \Lang::get('Total') . '</th>
                                    <th>' . \Lang::get('Subject') . '</th>
                                    <th>' . \Lang::get('Status') . '</th>
                                </tr>
                            </thead>
                        <tbody class="sortable">';
                    if (count($mp_leaves) > 0) {
                        foreach ($mp_leaves as $m) {
                            $to_date = Carbon::parse($m->to_date);
                            $from_date = Carbon::parse($m->from_date);
                            $total_days = $to_date->diffInDays($from_date);
                            if ($m->status == 1) {
                                $m->leave_status = '<span class=""> <i class="fa  fa-hourglass"></i></span>';
                            } else if ($m->status == 2) {
                                $m->leave_status = '<span class=""> <i class="fa fa-check"></i></span>';
                            } else if ($m->status == 3) {
                                $m->leave_status = '<span class=""> <i class="fa fa-times"></i></span>';
                            } else {
                                $m->leave_status = '<span class=""> <i class="fa fa-eye"></i></span>';
                            }

                            $mp_leaves_list .= '<tr>
                                    <td>' . digitDateLang(nanoDateFormat($m->from_date)) . '</td>
                                    <td>' . digitDateLang(nanoDateFormat($m->to_date)) . '</td>
                                    <td>' . digitDateLang($total_days) . '</td>
                                    <td>' . $m->note . '</td>
                                    <td style="text-align:center;">' . $m->leave_status . '</td>
                                </tr>';
                        }
                    }
                    $mp_leaves_list .= '</tbody></table>';
                    $data['mp_leaves'] = $mp_leaves_list;

                    //mp appointment list
                    $mp_appointment_list = '<table class="table table-sm table-bordered table-striped mb-4">
                            <thead>
                                <tr>
                                    <th>' . \Lang::get('Date') . '</th>
                                    <th>' . \Lang::get('Topic') . '</th>
                                    <th>' . \Lang::get('From') . '</th>
                                    <th>' . \Lang::get('To') . '</th>
                                </tr>
                            </thead>
                        <tbody class="sortable">';
                    if (count($mp_appointments) > 0) {
                        foreach ($mp_appointments as $m) {
                            if ($m->status == 1) {
                                $m->appointment_status = '<span class=""> <i class="fa  fa-hourglass"></i></span>';
                            } else if ($m->status == 2) {
                                $m->appointment_status = '<span class=""> <i class="fa fa-check"></i></span>';
                            } else if ($m->status == 3) {
                                $m->appointment_status = '<span class=""> <i class="fa fa-times"></i></span>';
                            } else {
                                $m->appointment_status = '<span class=""> <i class="fa fa-eye"></i></span>';
                            }

                            $mp_appointment_list .= '<tr>
                                    <td>' . digitDateLang(nanoDateFormat($m->date)) . '</td>
                                    <td>' . $m->topics . '</td>
                                    <td>' . digitDateLang($m->time_from) . '</td>
                                    <td>' . digitDateLang($m->time_to) . '</td>
                                    <td style="text-align:center;">' . $m->appointment_status . '</td>
                                </tr>';
                        }
                    }
                    $mp_appointment_list .= '</tbody></table>';
                    $data['mp_appointments'] = $mp_appointment_list;
                    //for notice bar graph
                    //SELECT notice_from, rule_number, count(id) as total_notices FROM `notices` where notice_from=2 and status>0 and created_at between '2021-05-01' and '2021-08-05' group by rule_number

                    //rule_number and statuswise summary for donut chart
                    //SELECT notice_from, rule_number, status, count(id) as total_notices FROM `notices` where notice_from=2 and created_at between '2021-05-01' and '2021-08-05' group by rule_number,status

                    $data['notice_bar_chart'] = Notice::groupBy('rule_number')->select('rule_number', DB::raw('count(*) as total_notices'))
                        ->whereBetween('created_at', [$start, $end])
                        //->where('notice_from', authInfo()->id)
                        ->get();
                    if (count($data['notice_bar_chart']) > 0) {
                        foreach ($data['notice_bar_chart'] as $b) {
                            $b->rule_number = digitDateLang($b->rule_number);
                            //$b->total_notices = digitDateLang($b->total_notices);
                        }
                    }

                    $data['notice_donut_chart'] = Notice::groupBy(array('rule_number', 'status'))->select('rule_number', 'status', DB::raw('count(*) as total_notices'))
                        ->whereBetween('created_at', [$start, $end])
                        //->where('notice_from', authInfo()->id)
                        ->get();

                    if (count($data['notice_donut_chart']) > 0) {
                        $data['donut_list'] = [];
                        $data['notice_donut_chart']  = $this->group_by("rule_number", json_decode(json_encode($data['notice_donut_chart'], true), true));
                        foreach ($data['notice_donut_chart'] as $key => $val) {
                            foreach ($data['notice_donut_chart'][$key] as $k => $v) {
                                $data['notice_donut_chart'][$key][$k]['status_data'] = globalStatus('notice', $data['notice_donut_chart'][$key][$k]['status'], 1);
                            }
                        }
                        $data['donut_list'][] = $data['notice_donut_chart'];
                    }

                    /* $active_users = Active::usersWithinHours(24)->get();

                    $active_user_list = '<table class="table table-sm table-bordered table-striped mb-4">
                            <thead>
                                <tr>
                                    <th>' . \Lang::get('Serial') . '</th>
                                    <th>' . \Lang::get('Name') . '</th>
                                    <th>' . \Lang::get('Email') . '</th>
                                    <th>' . \Lang::get('IP') . '</th>
                                </tr>
                            </thead>
                        <tbody class="sortable">';
                    if (count($active_users) > 0) {
                        $sn = 1;
                        foreach ($active_users as $u) {
                            $u->user->name = ((session()->get('language') == 'bn')) ? $u->user->name_bn : $u->user->name;
                            $active_user_list .= '<tr>
                                    <td>' . digitDateLang($sn++) . '</td>
                                    <td>' . $u->user->name_bn . '</td>
                                    <td>' . $u->user->email . '</td>
                                    <td>' . $u->ip_address . '</td>
                                </tr>';
                        }
                    }
                    $active_user_list .= '</tbody></table>';
                    $data['active_users'] = $active_user_list; */
                }

                echo json_encode(array('status' => true, 'data' => $data), true);
            } else if ($module == 'my_activity') {
                if ($session_id !== '' && $session_id > 0) {
                    $session_data = ParliamentSession::where('parliament_sessions.id', $session_id)
                        ->leftJoin('parliaments', 'parliaments.id', '=', 'parliament_sessions.parliament_id')
                        ->select('parliament_sessions.*', 'parliaments.parliament_number')
                        ->first();
                    if (isset($session_data->date_from) && isset($session_data->date_to)) {
                        $start = date('Y-m-d', strtotime($session_data->date_from));
                        $end = date('Y-m-d', strtotime($session_data->date_to));
                    }
                } else {
                    //list all current session's record
                    $session_data = ParliamentSession::where('parliament_sessions.status', 1)
                        ->leftJoin('parliaments', 'parliaments.id', '=', 'parliament_sessions.parliament_id')
                        ->select('parliament_sessions.*', 'parliaments.parliament_number')
                        ->first();
                    if (isset($session_data->date_from) && isset($session_data->date_to)) {
                        $start = date('Y-m-d', strtotime($session_data->date_from));
                        $end = date('Y-m-d', strtotime($session_data->date_to));
                    }
                }

                $my_calendar_data = $this->mpCalendar($start, $end);
                $order_of_days = OrderOfDay::whereBetween('order_date', [$start, $end])->get();
                //echo json_encode(array('status' => true, 'data' => $order_of_days), true);
                $appointment_request_data = '';
                $calender_request_list = [];
                if (count($my_calendar_data['appointment_request_list']) > 0) {
                    $sn = 1;
                    foreach ($my_calendar_data['appointment_request_list'] as $d) {
                        $time_string = '';
                        $status_string = '';
                        $profile_name = '';
                        if (session()->get('language') == 'bn') {
                            $profile_name = $d->request_to_name_bng;
                        } else {
                            $profile_name = $d->request_to_name_eng;
                        }
                        if ($d->created_by == authInfo()->id) {
                            $time_string = $d->topics . ' - ' . $d->place;
                        } else {
                            $time_string = $d->new_date . '<br />' . $d->new_time_from . ' to ' . $d->new_time_to . '<br />' . $d->new_place;
                        }
                        if ($d->status == 0) {
                            $status_string = \Lang::get("Pending");
                        } else if ($d->status == 1) {
                            $status_string = \Lang::get("Approved");
                        } else if ($d->status == 2) {
                            $status_string = \Lang::get("Declined");
                        }

                        $d->start = $d->date;
                        $d->title = $profile_name;
                        $d->date_calendar = digitDateLang(nanoDateFormat($d->date));
                        $calender_request_list[] = $d;

                        $appointment_request_data .= '<tr><td>' . digitDateLang($sn++) . '</td><td>' . digitDateLang(nanoDateFormat($d->date)) . '</td><td>' . $profile_name . '</td><td>' . digitDateLang($d->time_form) . ' - ' . digitDateLang($d->time_to) . '</td><td>' . $time_string . '</td><td>' . $status_string . '</td></tr>';
                    }
                }
                $appointment_received_data = '';

                $calender_received_list = [];
                if (count($my_calendar_data['appointment_received_list']) > 0) {
                    $sn = 1;
                    foreach ($my_calendar_data['appointment_received_list'] as $d) {
                        $time_string = '';
                        $status_string = '';
                        $profile_name = '';
                        if (session()->get('language') == 'bn') {
                            $profile_name = $d->request_by_name_bng;
                        } else {
                            $profile_name = $d->request_by_name_eng;
                        }
                        if ($d->requested_to == authInfo()->id) {
                            $time_string = $d->topics . ' - ' . $d->place;
                        } else {
                            $time_string = $d->new_date . '<br />' . $d->new_time_from . ' to ' . $d->new_time_to . '<br />' . $d->new_place;
                        }
                        if ($d->status == 0) {
                            $status_string = \Lang::get("Pending");
                        } else if ($d->status == 1) {
                            $status_string = \Lang::get("Approved");
                        } else if ($d->status == 2) {
                            $status_string = \Lang::get("Declined");
                        }
                        $d->start = $d->date;
                        $d->date_calendar = digitDateLang(nanoDateFormat($d->date));
                        $d->title = $profile_name;
                        $calender_received_list[] = $d;
                        $appointment_received_data .= '<tr><td>' . digitDateLang($sn++) . '</td><td>' . digitDateLang(nanoDateFormat($d->date)) . '</td><td>' . $profile_name . '</td><td>' . digitDateLang($d->time_form) . ' - ' . digitDateLang($d->time_to) . '</td><td>' . $time_string . '</td><td>' . $status_string . '</td></tr>';
                    }
                }

                $meeting_list = "";
                $calendar_meeting_list = [];

                if (count($my_calendar_data['meeting_list']) > 0) {
                    $sn = 1;
                    foreach ($my_calendar_data['meeting_list'] as $d) {
                        $time_string = '';
                        $status_string = '';
                        $room_name = "";

                        if (session()->get('language') == 'bn') {
                            $room_name = $d->room_name_bn;
                        } else {
                            $room_name = $d->room_name_bn;
                        }
                        $d->room_name = $room_name;
                        $d->start = $d->date_meeting;
                        $d->end = $d->time_ending;
                        $d->date_meeting = digitDateLang(nanoDateFormat($d->date_meeting));
                        $d->date_meeting_calendar = nanoDateFormat($d->date_meeting);
                        $d->time_starting = digitDateLang($d->time_starting);
                        $d->time_ending = digitDateLang($d->time_ending);
                        $d->title = $d->committee_name;
                        $calendar_meeting_list[] = $d;
                        $meeting_list .= '<tr><td>' . digitDateLang($sn++) . '</td><td>' . $d->date_meeting . '</td><td>' . $d->committee_name . '</td><td>' . $d->time_starting . ' - ' . $d->time_ending . '</td><td>' . $d->room_name . '</td></tr>';
                    }
                }

                $calendar_meeting_list = array_merge($calendar_meeting_list, $calender_request_list);
                $calendar_meeting_list = array_merge($calendar_meeting_list, $calender_received_list);

                $data['appointment_request_data'] = $appointment_request_data;
                $data['appointment_received_data'] = $appointment_received_data;
                $data['meeting_list'] = $meeting_list;

                //calendar meeting_list holds all data of (meeting+appointment_request+appoinment_received) 
                $data['calendar_meeting_list'] = $calendar_meeting_list;

                //return $final_result;
                echo json_encode(array('status' => true, 'data' => $data));
            } else {
                echo json_encode(array('status' => true, 'data' => []));
            }
        }
    }

    private function mpCalendar($start_date, $end_date)
    {
        $start_date = date('Y-m-d', strtotime($start_date));
        $end_date = date('Y-m-d', strtotime($end_date));
        //for appointment
        $data['appointment_request_list'] = Appointment::where('appointments.created_by', authInfo()->id)
            //->where('appointments.requested_to', '!=', authInfo()->id)
            ->where('appointments.status', 1)
            ->whereBetween('appointments.date', [$start_date, $end_date])
            ->leftJoin('v2_profiles', 'v2_profiles.user_id', '=', 'appointments.requested_to')
            ->select('appointments.*', 'v2_profiles.nameEng as request_to_name_eng', 'v2_profiles.nameBng as request_to_name_bng')
            ->get();

        $data['appointment_received_list'] = Appointment::where('appointments.requested_to', authInfo()->id)
            //->where('appointments.created_by', '!=', authInfo()->id)
            ->where('appointments.status', 1)
            ->whereBetween('appointments.date', [$start_date, $end_date])
            ->leftJoin('v2_profiles', 'v2_profiles.user_id', '=', 'appointments.created_by')
            ->select('appointments.*', 'v2_profiles.nameEng as request_by_name_eng', 'v2_profiles.nameBng as request_by_name_bng')
            ->get();

        $data['meeting_list'] = CommitteeMeeting::where('standing_committee_members.user_id', authInfo()->id)
            ->whereBetween('committee_meetings.date_meeting', [$start_date, $end_date])
            ->leftJoin('standing_committee_members', 'standing_committee_members.id', '=', 'committee_meetings.new_standing_committees_id')
            ->leftJoin('new_standing_committees', 'new_standing_committees.id', '=', 'committee_meetings.new_standing_committees_id')
            ->leftJoin('committee_rooms', 'committee_rooms.id', '=', 'committee_meetings.committee_rooms_id')
            ->select('committee_meetings.*', 'standing_committee_members.user_id', 'new_standing_committees.committee_name', 'committee_rooms.name_bn as room_name_bn', 'committee_rooms.name_en as room_name_en')
            ->get();

        return $data;
    }

    public function generatePDF($session_id = null, $type = null)
    {
        if ($type == 'poripotro') {
            if ($session_id !== '' && $session_id > 0) {
                $poripotro_list = Circular::where('circulars.parliament_session_id', $session_id)
                    ->leftJoin('ministries', 'ministries.id', '=', 'circulars.ministry_id')
                    ->select('circulars.*', 'ministries.name as name_eng', 'ministries.name_bn')
                    ->get();
            } else {
                $start = '';
                $end = '';
                $session_data = ParliamentSession::where('parliament_sessions.id', $session_id)
                    ->leftJoin('parliaments', 'parliaments.id', '=', 'parliament_sessions.parliament_id')
                    ->select('parliament_sessions.*', 'parliaments.parliament_number')
                    ->first();
                if (isset($session_data->date_from) && isset($session_data->date_to)) {
                    $start = date('Y-m-d', strtotime($session_data->date_from));
                    $end = date('Y-m-d', strtotime($session_data->date_to));
                }
                $poripotro_list = Circular::whereBetween('date', [$start, $end])
                    ->leftJoin('ministries', 'ministries.id', '=', 'circulars.ministry_id')
                    ->select('circulars.*', 'ministries.name as ministry_name_eng', 'ministries.name_bn as ministry_name_bn')
                    ->get();
            }

            $final_list = '<table class="table table-sm table-bordered table-striped">
            <thead>
                <tr style="border:1px solid;">
                    <th>' . \Lang::get('Date') . '</th>
                    <th>' . \Lang::get('Ministry/Wing') . '</th>
                </tr>
            </thead>
            <tbody>';
            if (count($poripotro_list) > 0) {
                foreach ($poripotro_list as $p) {
                    $final_list .= '<tr><td>' . digitDateLang(nanoDateFormat($p->date)) . '</td><td>' . $p->ministry_name_bn . '</td></tr>';
                }
            }
            $final_list .= '</tbody></table>';

            $data['common_header']   = \Lang::get("Bangladesh National Parliament");
            $data['list_header']     = \Lang::get("Circular");
            $data['record_list']     = $final_list;
            $pdf                     = PDF::loadView('report.pdf.poripotro', $data);
            $pdfString               = $pdf->Output('', 'S');
            $pdfBase64               = base64_encode($pdfString);
            return 'data:application/pdf;base64,' . $pdfBase64;
        }
    }

    private function group_by($key, $data)
    {
        $result = array();

        foreach ($data as $val) {
            if (array_key_exists($key, $val)) {
                $result[$val[$key]][] = $val;
            } else {
                $result[""][] = $val;
            }
        }

        return $result;
    }

    public function activeUser()
    {
        return view('backend.dashboard.active_users');
    }

    public function getActiveUser()
    {
        $active_users = Active::usersWithinHours(24)->get();

        return Datatables::of($active_users)
            ->addColumn('name', function ($row) {
                return ((session()->get('language') == 'bn')) ? $row->user->name_bn : $row->user->name;
            })
            ->addColumn('email', function ($row) {
                return $row->user->email;
            })
            ->addColumn('login_time', function ($row) {
                return digitDateLang(date('d-m-Y H:i:s', $row->last_activity));
            })
            ->escapeColumns([]) // to render html
            ->make(true);
    }

    public function getLoginActivity()
    {
        $user_list = LoginActivity::leftJoin('users', 'users.id', '=', 'login_activities.user_id')
            ->select("login_activities.*", "users.name", "users.name_bn", "users.email")
            ->orderBy('login_activities.id', 'desc');

        return Datatables::of($user_list)
            ->addColumn('name', function ($row) {
                return ((session()->get('language') == 'bn')) ? $row->name_bn : $row->name;
            })
            ->addColumn('email', function ($row) {
                return $row->email;
            })
            ->addColumn('login_time', function ($row) {
                return ($row->login_time != '') ? digitDateLang(date('d-m-Y H:i:s', strtotime($row->login_time))) : '';
            })
            ->addColumn('logout_time', function ($row) {
                return ($row->logout_time != '') ? digitDateLang(date('d-m-Y H:i:s', strtotime($row->logout_time))) : '';
            })
            ->addColumn('duration', function ($row) {
                $startTime = strtotime($row->login_time);
                $endTime = strtotime($row->logout_time);
                return ($row->logout_time != '' && $row->login_time != '') ? digitDateLang(\Carbon\CarbonInterval::seconds($endTime - $startTime)->cascade()->forHumans()) : '';
            })
            ->addColumn('action', function ($row) {
                $user_name = ((session()->get('language') == 'bn')) ? $row->name_bn : $row->name;
                return '<a href="javascript:;" onClick="userLogDetails(' . $row->user_id . ')" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a> <input type="hidden" id="user_name_' . $row->user_id . '" value="' . $user_name . '">';
            })
            ->escapeColumns([]) // to render html
            ->make(true);
    }

    public function getLogDetails(Request $request)
    {
        $user_id = $request->user_id;
        $date_list = (isset($request->date) && $request->date != '') ? explode('~', $request->date) : [];
        $start_date = (count($date_list) > 0) ? date('Y-m-d', strtotime($date_list[0])) : '';
        $end_date = (count($date_list) > 0) ? date('Y-m-d', strtotime($date_list[1])) : '';

        $log_list = RouteLog::where('user_id', $user_id)
            ->whereBetween(DB::raw("DATE_FORMAT(route_logs.created_at,'%Y-%m-%d')"), [$start_date, $end_date])
            ->leftJoin('users', 'users.id', '=', 'route_logs.user_id')
            ->select("route_logs.*", "users.name", "users.name_bn", "users.email")
            ->orderBy('route_logs.id', 'desc');

        return Datatables::of($log_list)
            ->addColumn('name', function ($row) {
                return ((session()->get('language') == 'bn')) ? $row->name_bn : $row->name;
            })
            ->addColumn('email', function ($row) {
                return $row->email;
            })
            ->addColumn('time', function ($row) {
                return digitDateLang($row->created_at);
            })
            ->escapeColumns([]) // to render html
            ->make(true);
    }

    /* 
        audit_log module:
        tabbed:Logged in Users: by default last 24 hours
        1. currently loggedin users userid,name,email,IP,time
        2. Audit History(date range)

        tab2:User History
        track every url visiting by a loggedin user..
    */
}
