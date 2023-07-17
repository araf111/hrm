<?php

namespace App\Http\Controllers\Backend\TravelAllowance;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Model\TravelAllowanceBill;
use App\Model\TravelAllowanceBillStatus;
use App\Model\TravelAllowanceBillType;
use App\Model\TravelAllowanceBillDetails;
use App\Model\TravelDailyAllowanceBillDetail;
use App\Model\Profile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Lang;
use PDF;

class TravelAllowanceBillController extends Controller
{
    private $submissionNumberStart = 1001;

    public function index(TravelAllowanceBill $allowanceBill, Request $request)
    {

        if (authInfo()->usertype == 'mp' || authInfo()->usertype == 'ps') {
            if (authInfo()->usertype == 'mp') {
                $status = 1;
            } else {
                $status = 0;
            }

            $bills = $allowanceBill
                ->with(['status', 'details'])
                ->where('bill_for', $this->getMpId())
                ->orderBy('submission_no', 'desc')
                ->get();

            $data['bills'] = $bills;
            $data['status'] = $status;

            if (isApi()) {
                $response['status']    = 'success'; // return data
                $response['message']    = ''; // return data
                $response['api_info']    = $data; // return data
                return response()->json($response);
            }
            return view('backend.travelAllowance.bills', $data);
        } else {
            return redirect()->route('dashboard')->with('error', Lang::get('You are not allowed on this menu!'));
        }
    }

    public function create(Request $request)
    {
        if (authInfo()->usertype == 'mp') {
            $css = "display:inline-block;margin-bottom:15px;";
        } else {
            $css = "display:none";
        }

        $lastBillId = TravelAllowanceBill::select('submission_no')->orderBy('id', 'desc')->first();
        if ($lastBillId) {
            $lastSubmissionId = $lastBillId->submission_no;
        } else {
            $lastSubmissionId = '1000';
        }
        $billTypes = TravelAllowanceBillType::offset(0)->limit(2)->get();
        $billTypesTwo = TravelAllowanceBillType::offset(2)->limit(2)->get();
        $times = array('পূর্বাহ্ন', 'অপরাহ্ন');
        $timesEn = array('Forenoon', 'Afternoon');
        $travelTypes = array('সড়ক', 'বিমান');
        $travelTypesEn = array('Road', 'Biman');

        $data = [
            'billTypes' => $billTypes,
            'billTypesTwo' => $billTypesTwo,
            'times' => $times,
            'timesEn' => $timesEn,
            'travelTypes' => $travelTypes,
            'travelTypesEn' => $travelTypesEn,
            'lastSubmissionId' => $lastSubmissionId,
            'user'      => $request->user(),
            'css'      => $css
        ];

        if (isApi()) {
                $response['status']    = 'success'; // return data
                $response['message']    = ''; // return data
                $response['api_info']    = $data; // return data
                return response()->json($response);
            }

        return view('backend.travelAllowance.bills-add', $data);
    }

    public function store(Request $request, TravelAllowanceBill $allowanceBill)
    {
        //dd($request->all());
        if (isApi()) {
            $request->data = json_decode($request->data,true);
            $billData = [
                'submission_no'     => $this->getNextSubmissionNumber(),
                'bill_status_id'       => 1,
                'bill_for'             => $this->getMpId(),
                'bill_by'              => $request->user_id,
                'updated_at'           => $allowanceBill->updated_at = null
            ];
            $record = $allowanceBill->create($billData);
            $billDetailsData = $this->getBillDetails($request->data);
            $dailyBillDetailsData = $this->getDailyBillDetails($request->data);
            $record->details()->createMany($billDetailsData);

            $record->dailyallowdetails()->createMany($dailyBillDetailsData);
            $response['status']   = 'success';
            $response['message']  = 'Data Inserted successfully';
            $response['api_info'] = [];
            return response()->json($response);
        }
        DB::beginTransaction();
        try {
            $billData = [
                'submission_no'     => $this->getNextSubmissionNumber(),
                'bill_status_id'       => 1,
                'bill_for'             => $this->getMpId(),
                'bill_by'              => $request->user()->id,
                'updated_at'           => $allowanceBill->updated_at = null
            ];

            $record = $allowanceBill->create($billData);
            $billDetailsData = $this->getBillDetails($request);
            $dailyBillDetailsData = $this->getDailyBillDetails($request);
            $record->details()->createMany($billDetailsData);
            $record->dailyallowdetails()->createMany($dailyBillDetailsData);

            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            dd($e);
            $errorMessage = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";
            Session::flash('error', $customMessage, true);
            return response()->json(['status' => 'error']);
        }
    }

    public function sendBillByMP(Request $request, TravelAllowanceBill $allowanceBill)
    {
        DB::beginTransaction();
        try {
            $billData = [
                'submission_no'     => $this->getNextSubmissionNumber(),
                "bill_submission_date" => now()->toDateString(),
                'bill_status_id'       => 2,
                'bill_for'             => $this->getMpId(),
                'bill_by'              => $request->user()->id,
                'updated_at'           => $allowanceBill->updated_at = null
            ];

            $record = $allowanceBill->create($billData);
            $billDetailsData = $this->getBillDetails($request);
            $dailyBillDetailsData = $this->getDailyBillDetails($request);
            $record->details()->createMany($billDetailsData);

            $record->dailyallowdetails()->createMany($dailyBillDetailsData);
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            dd($e);
            $errorMessage = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";
            Session::flash('error', $customMessage, true);
            return response()->json(['status' => 'error']);
        }
    }

    // public function view(int $id, Request $request)
    // {
    //     $billTypes = TravelAllowanceBillType::all();

    //     $bill = TravelAllowanceBill::findOrFail($id);

    //     $bill->load(['status','details','forUser', 'byUser']);

    //     $data = [
    //         'billTypes' => $billTypes,
    //         'user'      => request()->user(),
    //         'bill'      => $bill,
    //         'view'      => 'true'
    //     ];

    //     // dd($data);

    //     return view('backend.travelAllowance.bills-view', $data);
    // }
    public function view(int $id, TravelAllowanceBill $travelAllowanceBill, TravelDailyAllowanceBillDetail $dailyBillDetails)
    {
        $times = array('পূর্বাহ্ন', 'অপরাহ্ন');
        $timesEn = array('Forenoon', 'Afternoon');
        $travelTypes = array('সড়ক', 'বিমান');
        $travelTypesEn = array('Road', 'Biman');
        $billTypes = TravelAllowanceBillType::offset(0)->limit(2)->get();
        $billTypesTwo = TravelAllowanceBillType::offset(2)->limit(2)->get();

        $bill = $travelAllowanceBill->findOrFail($id);
        $bill->load(['status', 'details', 'dailyallowdetails','forUser', 'byUser','details.billType']);
        $bill->load(['status', 'details', 'forUser', 'byUser']);

        $data = [
            'billTypes' => $billTypes,
            'billTypesTwo' => $billTypesTwo,
            'user'      => request()->user(),
            'bills'      => $bill,
            'times'      => $times,
            'timesEn'      => $timesEn,
            'travelTypes' => $travelTypes,
            'travelTypesEn' => $travelTypesEn,
            'view'      => 'false'
        ];

        // dd($data);

        return view('backend.travelAllowance.bills-view', $data);
    }

    public function edit(int $id, TravelAllowanceBill $travelAllowanceBill, TravelDailyAllowanceBillDetail $dailyBillDetails)
    {
        $times = array('পূর্বাহ্ন', 'অপরাহ্ন');
        $timesEn = array('Forenoon', 'Afternoon');
        $travelTypes = array('সড়ক', 'বিমান');
        $travelTypesEn = array('Road', 'Biman');
        $billTypes = TravelAllowanceBillType::offset(0)->limit(2)->get();
        $billTypesTwo = TravelAllowanceBillType::offset(2)->limit(2)->get();

        $bill = $travelAllowanceBill->findOrFail($id);

        $bill->load(['status', 'details', 'dailyallowdetails', 'forUser', 'byUser', 'details.billType']);

        $data = [
            'billTypes' => $billTypes,
            'billTypesTwo' => $billTypesTwo,
            'user'      => request()->user(),
            'bills'      => $bill,
            'times'      => $times,
            'timesEn'      => $timesEn,
            'travelTypes' => $travelTypes,
            'travelTypesEn' => $travelTypesEn,
            'view'      => 'false'
        ];

        return view('backend.travelAllowance.bills-edit', $data);
    }

    public function billItemEditModal(Request $request, TravelAllowanceBill $travelAllowanceBill)
    {

        $id = $request->id;
        $bill_id = $request->bill_id;
        $times = array('পূর্বাহ্ন', 'অপরাহ্ন');
        $timesEn = array('Forenoon', 'Afternoon');
        $travelTypes = array('সড়ক', 'বিমান');
        $travelTypesEn = array('Road', 'Biman');
        $billTypes = TravelAllowanceBillType::offset(0)->limit(2)->get();
        $billTypesTwo = TravelAllowanceBillType::offset(2)->limit(2)->get();

        $billData = TravelAllowanceBillDetails::where('id', $id)->where('bill_id', $bill_id)->first();
        $billName = TravelAllowanceBillType::where('id', $billData->bill_type_id)->first();



        if ($billData->bill_type_id == 1) {
            $style = 'display:visible';
        } else {
            $style = 'display:none';
        }

        if ($billData->bill_type_id == 2) {
            $style2 = 'display:visible';
        } else {
            $style2 = 'display:none';
        }

        // dd($billData);

        $returnHTML = view('backend.travelAllowance.bills-edit-modal', ['billTypes' => $billTypes, 'billTypesTwo' => $billTypesTwo, 'travelTypes' => $travelTypes, 'times' => $times, 'billData' => $billData, 'billName' => $billName, 'billId' => $bill_id, 'style' => $style, 'style2' => $style2, 'timesEn' => $timesEn, 'travelTypesEn' => $travelTypesEn])->render();
        return response()->json($returnHTML);
    }

    public function billItemUpdate(Request $request)
    {
        //dd($request->all());
        $bill_Id = $request->bill_id;
        $billId = $request->billId;
        // dd($billId);
        $billType = $request->billType;
        if ($billType == 'ভ্রমন ভাতা' or $billType == 'Travel allowance') {
            $billType = 1;
        } elseif ($billType == 'ভ্রমন ব্যয়' or $billType == 'Travel expenses') {
            $billType = 2;
        }
        $fromPlace = $request->fromPlace;
        $travel_from_date = Carbon::parseFromLocale($request->travel_from_date)->toDateString();
        $fromTime = $request->fromTime;
        $toPlace = $request->toPlace;
        $travel_to_date = Carbon::parseFromLocale($request->travel_to_date)->toDateString();
        $toTime = $request->toTime;
        $travelType = $request->travelType;
        $class = $request->class;
        $fareAmount = $request->costAmount;
        $distance = $request->distance;
        $tFareAmount = $request->tCostAmount;
        $costCount = $request->costCount;
        $allowCount = $request->expenseCostAmount;
        $expenseTAmount = $request->expenseTAmount;

        $arr = array(
            'bill_id' => $billId,
            'bill_type_id' => $billType,
            'start_from' => $fromPlace,
            'start_date' => $travel_from_date,
            'start_time' => $fromTime,
            'end_to' => $toPlace,
            'end_date' => $travel_to_date,
            'end_time' => $toTime,
            'travel_by' => $travelType,
            'travel_class' => $class,
            'fare_times' => $costCount,
            'fare' => $fareAmount,
            'total_fare' => $expenseTAmount,
            'allowance_rate' => $allowCount,
            'distance_travel' => $distance,
            'total_allowance' => $tFareAmount
        );

        $sts = TravelAllowanceBillDetails::where('id', $bill_Id)->update($arr);
        // dd($sts);
        DB::commit();

        if ($sts) {
            return redirect(route('admin.travel_allowance.travelAllowanceBill.edit', $billId))->with('success', 'Bill Updated Successfully');
        } else {
            return redirect(route('admin.travel_allowance.travelAllowanceBill.edit', $billId))->with('error', 'Bill Not Created Successfully');
        }
        // $travelAllowanceBill = TravelAllowanceBill::findOrFail($id);

    }

    public function deleteBillItem(Request $request, $id)
    {
        try {
            $bill = TravelAllowanceBillDetails::find($id);
            $status = $bill->delete();
            return response()->json(["status" => "success"]);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            Session::flash('error', $customMessage, true);
            return response()->json(['status' => 'error']);
        }
    }


    public function update(int $id, Request $request)
    {
        $travelAllowanceBill = TravelAllowanceBill::findOrFail($id);

        $billData = [
            'status_id' => $this->getBillStatus($request->get('action'))->id,
        ];

        $billDetailsData = $this->getBillDetails($request);

        $status = DB::transaction(function () use ($travelAllowanceBill, $billData, $billDetailsData) {

            $travelAllowanceBill->update($billData);
            $travelAllowanceBill->details()->delete();
            return $travelAllowanceBill->details()->createMany($billDetailsData);
        });

        $responseData = ['status' => (bool)$status];

        return $request->wantsJson()
            ? response()->json($responseData)
            : response($responseData);
    }

    public function billSend(Request $request)
    {
        try {
            $bill = TravelAllowanceBill::find($request->id);
            $data = array(
                "bill_submission_date" => now()->toDateString(),
                "bill_status_id" => 2
            );
            $bill->update($data);
            return response()->json(["status" => "success"]);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            Session::flash('error', $customMessage, true);
            return response()->json(['status' => 'error']);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $bill = TravelAllowanceBill::find($id);
            $billDetails = TravelAllowanceBillDetails::where('bill_id', $id)->delete();
            $dailyBillDetails = TravelDailyAllowanceBillDetail::where('bill_id', $id)->delete();
            $status = $bill->delete();
            return response()->json(["status" => "success"]);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            Session::flash('error', $customMessage, true);
            return response()->json(['status' => 'error']);
        }
    }

    public function addNewDailyAllowance(Request $request)
    {
        $tableData = $request->pTableData;
        $tableData = json_decode($tableData, TRUE);

        $pTableDataTwo = $request->pTableDataTwo;
        $pTableDataTwo = json_decode($pTableDataTwo, TRUE);

        $pTableDataThree = $request->pTableDataThree;
        $pTableDataThree = json_decode($pTableDataThree, TRUE);


        foreach ($pTableDataTwo as $key => $value) {
            if (empty($key)) {
                unset($pTableDataTwo[$key]);
            }
        }

        foreach ($pTableDataThree as $key => $value) {
            if (empty($key)) {
                unset($pTableDataThree[$key]);
            }
        }

        $dailyPresentAllow = $pTableDataTwo[1]['dailyPresentAllow'];
        $dailStayAllowwithoutPresent = $pTableDataTwo[1]['dailStayAllowwithoutPresent'];
        $dailyTravelPresentAllow = $pTableDataThree[1]['dailyTravelPresentAllow'];
        $dailStayTravelAllowwithoutPresent = $pTableDataThree[1]['dailStayTravelAllowwithoutPresent'];

        DB::beginTransaction();
        try {
            $lastBillId = TravelAllowanceBill::select('id')->orderBy('id', 'desc')->first();
            $lastBillId = $lastBillId->id;

            foreach ($tableData as $travelallow) {

                $from_date = Carbon::parse($travelallow['fromDate'])->format('Y-m-d');
                $to_date = Carbon::parse($travelallow['toDate'])->format('Y-m-d');

                $days_between = (strtotime($to_date) - strtotime($from_date)) / 24 / 3600;
                if ($days_between == 1) {
                    $days_between = $days_between;
                } elseif ($days_between < 1) {
                    $days_between = $days_between + 1;
                } elseif ($days_between > 1) {
                    $days_between = $days_between + 1;
                }

                $totalPresentDate = $travelallow['attenDays'];
                $totalDateArr = explode(",", $totalPresentDate);
                $totalPresentDays = count($totalDateArr);

                $tStayDaywithoutAtten = $days_between - $totalPresentDays;

                $tDailyPresentAllow = $dailyPresentAllow * $travelallow['totalPresentDays'];
                $tDailyStayAllow = $dailStayAllowwithoutPresent * $travelallow['toalStayDayswithoutPresent'];
                $TdailyAllow = $tDailyPresentAllow + $tDailyStayAllow;

                $tDailyPresentTravelAllow = $dailyTravelPresentAllow * $travelallow['totalPresentDays'];
                $tDailyStayTravelAllow = $dailStayTravelAllowwithoutPresent * $travelallow['toalStayDayswithoutPresent'];
                $TdailyTravelAllow = $tDailyPresentTravelAllow + $tDailyStayTravelAllow;

                $newObj = new TravelDailyAllowanceBillDetail();
                $newObj->bill_id = $lastBillId;
                $newObj->date_from = $from_date;
                $newObj->date_to = $to_date;
                $newObj->attend_date = $totalPresentDate;
                $newObj->stay_reason = $travelallow['stayCause'];
                $newObj->total_days_stay = $days_between;
                $newObj->total_attended_days = $totalPresentDays;
                $newObj->total_nonattended_days = $tStayDaywithoutAtten;
                $newObj->daily_allowance_for_attended_days = $dailyPresentAllow;
                $newObj->daily_allowance_for_nonattended_days = $dailStayAllowwithoutPresent;
                $newObj->transport_allowance_for_attended_days = $dailyTravelPresentAllow;
                $newObj->transport_allowance_for_nonattended_days = $dailStayTravelAllowwithoutPresent;
                $newObj->total_daily_allowance_for_attended_days = $tDailyPresentAllow;
                $newObj->total_daily_allowance_for_nonattended_days = $tDailyStayAllow;
                $newObj->total_transport_allowance_for_attended_days = $tDailyPresentTravelAllow;
                $newObj->total_transport_allowance_for_nonattended_days = $tDailyStayTravelAllow;
                $newObj->updated_at = null;
                $newObj->save();
            }
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            Session::flash('error', $customMessage, true);
            return response()->json(['status' => 'error']);
        }
    }

    public function dailyBillItemEditModal(Request $request, TravelAllowanceBill $travelAllowanceBill)
    {
        $id = $request->id;
        $bill_id = $request->bill_id;

        $billData = TravelDailyAllowanceBillDetail::where('id', $id)->where('bill_id', $bill_id)->first();

        $returnHTML = view('backend.travelAllowance.daily-bill-edit-modal', ['billData' => $billData, 'billId' => $bill_id])->render();
        return response()->json($returnHTML);
    }

    public function dailyBillItemUpdate(Request $request)
    {

        $bill_Id = $request->bill_id;
        $billId = $request->billId;

        DB::beginTransaction();
        try {
            $from_date = Carbon::parse($request->daily_from_date)->format('Y-m-d');
            $to_date = Carbon::parse($request->daily_to_date)->format('Y-m-d');

            $days_between = (strtotime($to_date) - strtotime($from_date)) / 24 / 3600;
            if ($days_between == 1) {
                $days_between = $days_between;
            } elseif ($days_between < 1) {
                $days_between = $days_between + 1;
            } elseif ($days_between > 1) {
                $days_between = $days_between + 1;
            }

            $totalPresentDate = $request->atten_date;
            $totalDateArr = explode(",", $totalPresentDate);
            $totalPresentDays = count($totalDateArr);

            $tStayDaywithoutAtten = $days_between - $totalPresentDays;

            $tDailyPresentAllow = $request->daily_present_allow * $totalPresentDays;
            $tDailyStayAllow = $request->daily_stay_allow * $tStayDaywithoutAtten;
            $TdailyAllow = $tDailyPresentAllow + $tDailyStayAllow;

            $tDailyPresentTravelAllow = $request->daily_present_travel_allow * $totalPresentDays;
            $tDailyStayTravelAllow = $request->daily_travel_stay_allow * $tStayDaywithoutAtten;
            $TdailyTravelAllow = $tDailyPresentTravelAllow + $tDailyStayTravelAllow;

            $newObj = TravelDailyAllowanceBillDetail::findOrFail($bill_Id);
            $newObj->date_from = Carbon::parse($request->daily_from_date)->format('d-m-Y');
            $newObj->date_to = Carbon::parse($request->daily_to_date)->format('d-m-Y');
            $newObj->attend_date = $request->atten_date;
            $newObj->stay_reason = $request->stay_reason;
            $newObj->total_days_stay = $days_between;
            $newObj->total_attended_days = $totalPresentDays;
            $newObj->total_nonattended_days = $tStayDaywithoutAtten;
            $newObj->daily_allowance_for_attended_days = $request->daily_present_allow;
            $newObj->daily_allowance_for_nonattended_days = $request->daily_stay_allow;
            $newObj->transport_allowance_for_attended_days = $request->daily_present_travel_allow;
            $newObj->transport_allowance_for_nonattended_days = $request->daily_travel_stay_allow;
            $newObj->total_daily_allowance_for_attended_days = $tDailyPresentAllow;
            $newObj->total_daily_allowance_for_nonattended_days = $tDailyStayAllow;
            $newObj->total_transport_allowance_for_attended_days = $tDailyPresentTravelAllow;
            $newObj->total_transport_allowance_for_nonattended_days = $tDailyStayTravelAllow;
            $sts = $newObj->save();
            DB::commit();
            if ($sts) {
                return redirect(route('admin.travel_allowance.travelAllowanceBill.edit', $billId))->with('success', 'Bill Updated Successfully');
            } else {
                return redirect(route('admin.travel_allowance.travelAllowanceBill.edit', $billId))->with('error', 'Bill Not Created Successfully');
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            Session::flash('error', $customMessage, true);
            return response()->json(['status' => 'error']);
        }
    }

    public function deleteDailyBillItem(Request $request, $id)
    {
        try {
            $bill = TravelDailyAllowanceBillDetail::find($id);
            $status = $bill->delete();
            return response()->json(["status" => "success"]);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            Session::flash('error', $customMessage, true);
            return response()->json(['status' => 'error']);
        }
    }


    // helper fn's

    private function getNextSubmissionNumber(): int
    {

        $submissionNo = $this->submissionNumberStart;

        $isNotFirst = (TravelAllowanceBill::count() > 0);

        if ($isNotFirst) {
            $submissionNo = TravelAllowanceBill::orderByDesc('submission_no')->first()->submission_no + 1;
        }

        return $submissionNo;
    }

    private function getBillStatus($statusId)
    {
        $statusMap = [
            'draft' => 'Draft',
            'save'  => 'Waiting For Sending',
            'send'  => 'Waiting For Approval',
        ];

        $desiredStatus = $statusMap[$statusId];

        return TravelAllowanceBillStatus::where('name', $desiredStatus)->first();
    }

    private function getMpId()
    {

        $user = auth()->user();
        // if the user is MP
        if ($user->usertype === 'mp') {
            return $user->id;
        }
        return $user->psMpInfo->mp_user_id;
    }


    public function bn2endate($number)
    {
        $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "AM", "PM", "am", "pm", "cusec", "litre", "horse", "Jan", "Feb", "Mar", "Apr", "May", "Jun", 'Jul', "Aug", "Sep", "Oct", "Nov", "Dec", "January", "February", "March", "April", "May", "June", 'July', "August", "September", "October", "November", "December", "Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Weekend", "day", "week", "month", "year");
        $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০", "এ.এম", "পি.এম", "এ.এম", "পি.এম", "কিউসেক", "লিটার/সে.", "অশ্বশক্তি", "জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "অগাস্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর", "জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "অগাস্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর", "শনিবার", "রবিবার", "সোমবার", "মঙ্গলবার", "বুধবার", "বৃহস্পতিবার", "শুক্রবার", "সাপ্তাহিক ছুটি", "দিন", "সপ্তাহ", "মাস", "বছর");

        if (Session::get('language') == 'bn') {
            return str_replace($bn, $en, $number);
        } else {
            return str_replace($en, $bn, $number);
        }
    }


    private function getBillDetails($request)
    {
       /*
        {"pTableData":[{"fromPlace":"comilla","travel_from_date":"20-10-2021","fromTime":"পূর্বাহ্ন","toPlace":"dhaka","travel_to_date":"20-10-2021","toTime":"অপরাহ্ন","billType":"ভ্রমন ভাতা","travelType":"সড়ক","class":"","fareCount":"","allowCount":"","fareAmount":"৩৫০০","distance":"৫০","tFareAmount":"","expenseTAmount":"১৭৫০০০.০০"},
 {"fromPlace":"khulna","travel_from_date":"21-10-2021","fromTime":"অপরাহ্ন","toPlace":"dhaka","travel_to_date":"22-10-2021","toTime":"পূর্বাহ্ন","billType":"ভ্রমন ব্যয়","travelType":"বিমান","class":"first class","fareCount":"৪০০০","allowCount":"৬৫০০","fareAmount":"","distance":"","tFareAmount":"২৬০০০০০০.০০","expenseTAmount":""}],
  "pTableDataTwo" : "[]",
  "pTableDataThree": "[]",
  "pTableDataFour": "[]" }
       */
        if(isApi()){
            $tableData = json_encode($request['pTableData'],true);
        }
        else{
            $tableData = $request->pTableData;
        }

        $tableData = json_decode($tableData, TRUE);

        $listOfData = [];

        foreach ($tableData as $travelBill) {

            // $travelBill = $data['travelBill'];

            if ($travelBill['billType'] == 'ভ্রমন ভাতা' or $travelBill['billType'] == 'Travel allowance') {
                $billType = 1;
            } elseif ($travelBill['billType'] == 'ভ্রমন ব্যয়' or $travelBill['billType'] == 'Travel expenses') {
                $billType = 2;
            }
            if(!isApi()){
                $travel_from_date = $this->bn2endate($travelBill['travel_from_date']);
                $travel_to_date = $this->bn2endate($travelBill['travel_to_date']);
            }
            else{
                $travel_from_date = $travelBill['travel_from_date'];
                $travel_to_date = $travelBill['travel_to_date'];
            }

            $listOfData[] = [
                'bill_type_id'      => $billType,
                'start_from'        => $travelBill['fromPlace'],
                'start_date'        => (!isApi())?Carbon::parseFromLocale($travel_from_date)->toDateString():Carbon::parse($travel_from_date)->toDateString(),
                'start_time'        => $travelBill['fromTime'],
                'end_to'            => $travelBill['toPlace'],
                'end_date'          => (!isApi())?Carbon::parseFromLocale($travel_to_date)->toDateString():Carbon::parse($travel_to_date)->toDateString(),
                'end_time'          => $travelBill['toTime'],
                'travel_by'         => $travelBill['travelType'],
                'travel_class'      => (isset($travelBill['class']))?$travelBill['class']:'',
                'fare_times'        => bn2en($travelBill['fareCount']),
                'fare'              => bn2en($travelBill['fareAmount']),
                'total_fare'        => bn2en($travelBill['tFareAmount']),
                'allowance_rate'    => bn2en($travelBill['allowCount']),
                'distance_travel'   => bn2en($travelBill['distance']),
                'total_allowance'   => bn2en($travelBill['expenseTAmount']),
            ];
        }
        return $listOfData;
    }

    private function getDailyBillDetails($request)
    {
        if(isApi()){
            $tableDataTwo = (isset($request['pTableDataTwo']))?$request['pTableDataTwo']:'';
        }
        else{
            $tableDataTwo = $request->pTableDataTwo;
        }
        if(isApi()){
            $pTableDataThree = (isset($request['pTableDataThree']))?$request['pTableDataThree']:'';
        }
        else{
            $pTableDataThree = $request->pTableDataThree;
        }

        if(isApi()){
            $pTableDataFour = (isset($request['pTableDataFour']))?$request['pTableDataFour']:'';
        }
        else{
            $pTableDataFour = $request->pTableDataFour;
        }

        $tableDataTwo = json_decode($tableDataTwo, TRUE);
        $pTableDataThree = json_decode($pTableDataThree, TRUE);
        $pTableDataFour = json_decode($pTableDataFour, TRUE);

        $listOfData = [];
        $i = 0;

        if(is_array($tableDataTwo)){
            foreach ($tableDataTwo as $travelallow) {

                $from_date = Carbon::parse($travelallow['fromDate'])->format('Y-m-d');
                $to_date = Carbon::parse($travelallow['toDate'])->format('Y-m-d');
    
                $days_between = (strtotime($to_date) - strtotime($from_date)) / 24 / 3600;
                if ($days_between == 1) {
                    $days_between = $days_between;
                } elseif ($days_between < 1) {
                    $days_between = $days_between + 1;
                } elseif ($days_between > 1) {
                    $days_between = $days_between + 1;
                }
    
                $totalPresentDate = $travelallow['attenDays'];
                $totalDateArr = explode(",", $totalPresentDate);
                $totalPresentDays = count($totalDateArr);
    
                $tStayDaywithoutAtten = $days_between - $totalPresentDays;
    
                $dailyPresentAllow = $pTableDataThree[$i]['dailyPresentAllow'];
                $dailStayAllowwithoutPresent = $pTableDataThree[$i]['dailStayAllowwithoutPresent'];
                $dailyTravelPresentAllow = $pTableDataFour[$i]['dailyTravelPresentAllow'];
                $dailStayTravelAllowwithoutPresent = $pTableDataFour[$i]['dailStayTravelAllowwithoutPresent'];
    
                // dd($dailyPresentAllow);
    
                $tDailyPresentAllow = $dailyPresentAllow * $travelallow['totalPresentDays'];
                $tDailyStayAllow = $dailStayAllowwithoutPresent * $travelallow['toalStayDayswithoutPresent'];
                $TdailyAllow = $tDailyPresentAllow + $tDailyStayAllow;
    
                $tDailyPresentTravelAllow = $dailyTravelPresentAllow * $travelallow['totalPresentDays'];
                $tDailyStayTravelAllow = $dailStayTravelAllowwithoutPresent * $travelallow['toalStayDayswithoutPresent'];
                $TdailyTravelAllow = $tDailyPresentTravelAllow + $tDailyStayTravelAllow;
    
    
    
                $listOfData[] = [
                    'date_from' => $from_date,
                    'date_to' => $to_date,
                    'attend_date' => $totalPresentDate,
                    'stay_reason' => $travelallow['stayCause'],
                    'total_days_stay' => $days_between,
                    'total_attended_days' => $totalPresentDays,
                    'total_nonattended_days' => $tStayDaywithoutAtten,
                    'daily_allowance_for_attended_days' => $dailyPresentAllow,
                    'daily_allowance_for_nonattended_days' => $dailStayAllowwithoutPresent,
                    'transport_allowance_for_attended_days' => $dailyTravelPresentAllow,
                    'transport_allowance_for_nonattended_days' => $dailStayTravelAllowwithoutPresent,
                    'total_daily_allowance_for_attended_days' => $tDailyPresentAllow,
                    'total_daily_allowance_for_nonattended_days' => $tDailyStayAllow,
                    'total_transport_allowance_for_attended_days' => $tDailyPresentTravelAllow,
                    'total_transport_allowance_for_nonattended_days' => $tDailyStayTravelAllow,
                    'updated_at' => null
                ];
                $i++;
            }
        }
        

        return $listOfData;
    }

    public function waitingCccountsSectionList(TravelAllowanceBill $allowanceBill, Request $request)
    {
        if (authInfo()->usertype != 'speaker') {
            $bills = $allowanceBill
                ->with(['status', 'details', 'forUser', 'byUser', 'profileInfo'])
                ->where('bill_status_id', '2')
                ->orderBy('bill_submission_date', 'ASC')
                ->get();

            $data['bills'] = $bills;
            // dd($data);

            return view('backend.travelAllowance.waiting-cccounts-section-list', $data);
        } else {
            return redirect()->route('dashboard')->with('error', Lang::get('You are not allowed on this menu!'));
        }
    }

    public function billSendAccountSectionModal(TravelAllowanceBill $allowanceBill, Request $request)
    {

        $id = $request->id;

        $bill = $allowanceBill
            ->with(['status', 'details', 'forUser', 'byUser', 'profileInfo'])
            ->where('id', $id)
            ->first();

        $returnHTML = view('backend.travelAllowance.bill_send_account_section_modal', ['bill' => $bill])->render();
        return response()->json($returnHTML);
    }
    public function unickBillNumberCheck(TravelAllowanceBill $allowanceBill, Request $request)
    {

        $id = $request->id;
        $billNum = $request->billNum;
        if(!empty($billNum)){
            $bill = $allowanceBill
            ->where('bill_no', '=', $billNum)
            ->first();
            if(!empty($bill) && $bill->bill_no !=''){
                $sts = 1;
            }else{
                $sts = 0;
            }
        }else{
            $sts = 0;
        }

        return response()->json(['sts' => $sts]);
    }

    public function billSendAccountSection(Request $request)
    {

        try {

            $billNum = $request->bill_number;

            if(!empty($billNum)){
                $result = TravelAllowanceBill::where('bill_no', '=', $billNum)->first();
                if(!empty($result) && $result->bill_no !=''){
                    return redirect()->route('admin.travel_allowance.travelAllowanceBill.waiting-accounts-section-list')->with('error', Lang::get('this is duplicate bill number please change this number'));
                }
            }

            $bill = TravelAllowanceBill::find($request->bill_id);
            $data = array(
                "bill_no" => $request->bill_number,
                "bill_status_id" => 3
            );
            $status = $bill->update($data);
            if ($status == true) {
                return redirect()->route('admin.travel_allowance.travelAllowanceBill.waiting-accounts-section-list')->with('success', 'Successfully updated');
            } else {
                return redirect()->with('error', 'Not Successfully updated');
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            Session::flash('error', $customMessage, true);
            return response()->json(['status' => 'error']);
        }
    }

    public function billCheckList(TravelAllowanceBill $allowanceBill, Request $request)
    {
        if (authInfo()->usertype != 'speaker') {
            $bills = $allowanceBill
                ->with(['status', 'details', 'forUser', 'byUser', 'profileInfo'])
                ->where('bill_status_id', '3')
                ->orderBy('bill_submission_date', 'ASC')
                ->get();

            $data['bills'] = $bills;

            return view('backend.travelAllowance.bill-check-list', $data);
        } else {
            return redirect()->route('dashboard')->with('error', Lang::get('You are not allowed on this menu!'));
        }
    }

    public function billCheckModal(TravelAllowanceBill $allowanceBill, Request $request)
    {

        $id = $request->id;

        $bill = $allowanceBill
            ->with(['status', 'details', 'forUser', 'byUser', 'profileInfo'])
            ->where('id', $id)
            ->first();

        $returnHTML = view('backend.travelAllowance.bill_check_modal', ['bill' => $bill])->render();
        return response()->json($returnHTML);
    }

    public function billCheckAction(Request $request)
    {

        try {
            $bill = TravelAllowanceBill::find($request->bill_id);
            $data = array(
                "bill_cheque_no" => $request->cheque_number,
                "bill_status_id" => 4
            );
            $status = $bill->update($data);
            if ($status == true) {
                return redirect()->route('admin.travel_allowance.travelAllowanceBill.bill-check-list')->with('success', 'Successfully updated');
            } else {
                return redirect()->with('error', 'Not Successfully updated');
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            Session::flash('error', $customMessage, true);
            return response()->json(['status' => 'error']);
        }
    }

    public function checkPaymentList(TravelAllowanceBill $allowanceBill, Request $request)
    {
        if (authInfo()->usertype != 'speaker') {
            $bills = $allowanceBill
                ->with(['status', 'details', 'forUser', 'byUser', 'profileInfo'])
                ->where('bill_status_id', '4')
                ->orderBy('bill_submission_date', 'ASC')
                ->get();

            $data['bills'] = $bills;
            return view('backend.travelAllowance.check-payment-list', $data);
        } else {
            return redirect()->route('dashboard')->with('error', Lang::get('You are not allowed on this menu!'));
        }
    }

    public function checkPaymentModal(TravelAllowanceBill $allowanceBill, Request $request)
    {

        $id = $request->id;

        $bill = $allowanceBill
            ->with(['status', 'details', 'forUser', 'byUser', 'profileInfo'])
            ->where('id', $id)
            ->first();

        $returnHTML = view('backend.travelAllowance.check-payment-modal', ['bill' => $bill])->render();
        return response()->json($returnHTML);
    }

    public function checkPaymentAction(Request $request)
    {

        try {
            $bill = TravelAllowanceBill::find($request->bill_id);
            $data = array(
                "bill_status_id" => 5,
                "bill_issue_date" => now()->toDateString()
            );
            $status = $bill->update($data);
            if ($status == true) {
                return redirect()->route('admin.travel_allowance.travelAllowanceBill.check-payment-list')->with('success', 'Successfully updated');
            } else {
                return redirect()->with('error', 'Not Successfully updated');
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            Session::flash('error', $customMessage, true);
            return response()->json(['status' => 'error']);
        }
    }

    public function allBillList(TravelAllowanceBill $allowanceBill, Request $request)
    {
        if (authInfo()->usertype != 'speaker') {
            $all_status = TravelAllowanceBillStatus::all();
            $all_member = db::table('users')->select('id', 'name', 'name_bn')->get();
            $selection_area = db::table('constituencies')->select('id', 'name', 'bn_name', 'number')->get();

            $bills = $allowanceBill
                ->with(['status', 'details', 'profileInfo'])
                ->whereIn('bill_status_id', [1, 2, 3, 4, 5])
                ->orderByDesc('id')
                ->get();

            $data['bills'] = $bills;
            $data['all_status'] = $all_status;
            $data['all_member'] = $all_member;
            $data['selection_area'] = $selection_area;

            return view('backend.travelAllowance.all-bills', $data);
        } else {
            return redirect()->route('dashboard')->with('error', Lang::get('You are not allowed on this menu!'));
        }
    }
    public function travelAllowPdfOne(Request $request, $id)
    {

        $data['data'] = "Welcome Pdf Document";

        $pdf = PDF::loadView('backend.travelAllowance.travel-allow-pdf-one', $data);
        return $pdf->download('travel_allow_' . $id . '.pdf');
    }

    public function searchAll(TravelAllowanceBill $allowanceBill, Request $request)
    {

        $bills = $allowanceBill
            ->with(['status', 'details', 'profileInfo'])
            ->orderByDesc('id')
            ->get();

        $data['bills'] = $bills;

        $returnHTML = view('backend.travelAllowance.search-all', ['bills' => $bills])->render();
        return response()->json($returnHTML);
    }

    public function searchByStatus(TravelAllowanceBill $allowanceBill, TravelAllowanceBillStatus $billStatus, Request $request)
    {
        $status_ids = $billStatus
            ->select('id')
            ->where('name', 'LIKE', "%$request->bill_status%")
            ->orWhere('name_bn', 'LIKE', "%$request->bill_status%")
            ->orderBy('id', 'ASC')
            ->first();

        $bills = $allowanceBill
            ->with(['status', 'profileInfo'])
            ->where('bill_status_id', $status_ids->id)
            ->orderBy('id', 'ASC')
            ->get();

        $returnHTML = view('backend.travelAllowance.search-by-status', ['bills' => $bills])->render();
        return response()->json($returnHTML);
    }
    public function searchByName(TravelAllowanceBill $allowanceBill, Profile $profile, Request $request)
    {

        $user_arr = array();

        $query = DB::table('users')
            ->select('id')
            ->where('name', 'LIKE', "%$request->name%")
            ->orWhere('name_bn', 'LIKE', "%$request->name%")
            ->orderBy('id', 'ASC')
            ->get();

        if ($query) {
            foreach ($query as $each) {
                $user_arr[] = $each->id;
            }
        }

        $bills = $allowanceBill
            ->with(['status', 'profileInfo'])
            ->whereIn('bill_for', $user_arr)
            ->orderBy('id', 'ASC')
            ->get();

        $returnHTML = view('backend.travelAllowance.search-by-status', ['bills' => $bills])->render();
        return response()->json($returnHTML);
    }

    public function searchBySelectionArea(TravelAllowanceBill $allowanceBill, Profile $profile, Request $request)
    {

        $user_arr = array();
        $user_arr_2 = array();

        $query = DB::table('constituencies')
            ->select('number')
            ->where('number', $request->selection_area_no)
            ->orderBy('id', 'ASC')
            ->get();

        if ($query) {
            foreach ($query as $each) {
                $user_arr[] = $each->number;
            }
        }

        $query_2 = $profile
            ->with(['userInfo'])
            ->whereIn('constituency_id', $user_arr)
            ->orderBy('id', 'ASC')
            ->get();

        if ($query_2) {
            foreach ($query_2 as $each) {
                $user_arr_2[] = $each->userInfo->id;
            }
        }

        $bills = $allowanceBill
            ->with(['status', 'profileInfo'])
            ->whereIn('bill_for', $user_arr_2)
            ->orderBy('id', 'ASC')
            ->get();

        $returnHTML = view('backend.travelAllowance.search-by-status', ['bills' => $bills])->render();
        return response()->json($returnHTML);
    }

    public function addNewInList(Request $request, TravelAllowanceBill $allowanceBill)
    {

        DB::beginTransaction();
        try {

            $billId = $request->bill_id;
            $billType = $request->billType;
            if ($billType === 'ভ্রমন ভাতা' or $billType === 'Travel allowance') {
                $billType = 1;
                $fromPlace = $request->fromPlace;
                $travel_from_date = Carbon::parseFromLocale($request->travel_from_date)->toDateString();
                $fromTime = $request->fromTime;
                $toPlace = $request->toPlace;
                $travel_to_date = Carbon::parseFromLocale($request->travel_to_date)->toDateString();
                $toTime = $request->toTime;
                $travelType = $request->travelType;
                $class = $request->class;
                $fareAmount = $request->costAmount;
                $distance = $request->distance;
                $tFareAmount = $request->tCostAmount;
                $costCount = $request->costCount;
                $allowCount = $request->expenseCostAmount;
                $expenseTAmount = $request->expenseTAmount;
                // dd('ok');
                $sts = TravelAllowanceBillDetails::create([
                    'bill_id' => $billId,
                    'bill_type_id' => $billType,
                    'start_from' => $fromPlace,
                    'start_date' => $travel_from_date,
                    'start_time' => $fromTime,
                    'end_to' => $toPlace,
                    'end_date' => $travel_to_date,
                    'end_time' => $toTime,
                    'travel_by' => $travelType,
                    'travel_class' => $class,
                    'fare_times' => $costCount,
                    'fare' => $fareAmount,
                    'total_fare' => $expenseTAmount,
                    'allowance_rate' => $allowCount,
                    'distance_travel' => $distance,
                    'total_allowance' => $tFareAmount,
                ]);
            } elseif ($billType == 'ভ্রমন ব্যয়' or $billType == 'Travel expenses') {
                $billType = 2;
                $fromPlace = $request->fromPlace;
                $travel_from_date = Carbon::parseFromLocale($request->travel_from_date)->toDateString();
                $fromTime = $request->fromTime;
                $toPlace = $request->toPlace;
                $travel_to_date = Carbon::parseFromLocale($request->travel_to_date)->toDateString();
                $toTime = $request->toTime;
                $travelType = $request->travelTypeTwo;
                $class = $request->class;
                $fareAmount = $request->costAmount;
                $distance = $request->distance;
                $tFareAmount = $request->tCostAmount;
                $costCount = $request->costCount;
                $allowCount = $request->expenseCostAmount;
                $expenseTAmount = $request->expenseTAmount;
                // dd('ok');
                $sts = TravelAllowanceBillDetails::create([
                    'bill_id' => $billId,
                    'bill_type_id' => $billType,
                    'start_from' => $fromPlace,
                    'start_date' => $travel_from_date,
                    'start_time' => $fromTime,
                    'end_to' => $toPlace,
                    'end_date' => $travel_to_date,
                    'end_time' => $toTime,
                    'travel_by' => $travelType,
                    'travel_class' => $class,
                    'fare_times' => $costCount,
                    'fare' => $fareAmount,
                    'total_fare' => $expenseTAmount,
                    'allowance_rate' => $allowCount,
                    'distance_travel' => $distance,
                    'total_allowance' => $tFareAmount,
                ]);
            }

            // dd($sts);
            // dd('ok1');
            DB::commit();

            if ($sts) {
                return redirect(route('admin.travel_allowance.travelAllowanceBill.edit', $billId))->with('success', 'Bill Created Successfully');
            } else {
                return redirect(route('admin.travel_allowance.travelAllowanceBill.edit', $billId))->with('error', 'Bill Not Created Successfully');
            }
            // dd('ok2');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            $errorMessage = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            Session::flash('error', $customMessage, true);
            return response()->json(['status' => 'error']);
        }
    }
    public function addNewDailybillInList(Request $request)
    {

        // dd($request->all());
        $billId = $request->bill_id;
        DB::beginTransaction();
        try {
            $from_date = Carbon::parse($request->daily_from_date_in_edit_page)->format('Y-m-d');
            $to_date = Carbon::parse($request->daily_to_date_in_edit_page)->format('Y-m-d');

            $days_between = (strtotime($to_date) - strtotime($from_date)) / 24 / 3600;
            if ($days_between == 1) {
                $days_between = $days_between;
            } elseif ($days_between < 1) {
                $days_between = $days_between + 1;
            } elseif ($days_between > 1) {
                $days_between = $days_between + 1;
            }

            $totalPresentDate = $request->atten_date_in_edit_page;
            $totalDateArr = explode(",", $totalPresentDate);
            $totalPresentDays = count($totalDateArr);

            $tStayDaywithoutAtten = $days_between - $totalPresentDays;

            $tDailyPresentAllow = $request->daily_present_allow_in_edit_page * $totalPresentDays;
            $tDailyStayAllow = $request->daily_travel_allow_in_edit_page * $tStayDaywithoutAtten;
            $TdailyAllow = $tDailyPresentAllow + $tDailyStayAllow;

            $tDailyPresentTravelAllow = $request->daily_present_travel_allow_in_edit_page * $totalPresentDays;
            $tDailyStayTravelAllow = $request->daily_travel_stay_allow_in_edit_page * $tStayDaywithoutAtten;
            $TdailyTravelAllow = $tDailyPresentTravelAllow + $tDailyStayTravelAllow;
            $sts = TravelDailyAllowanceBillDetail::create([
                'bill_id' => $billId,
                'date_from' => Carbon::parse($request->daily_from_date_in_edit_page)->format('d-m-Y'),
                'date_to' => Carbon::parse($request->daily_to_date_in_edit_page)->format('d-m-Y'),
                'attend_date' => $request->atten_date_in_edit_page,
                'stay_reason' => $request->stay_reason_in_edit_page,
                'total_days_stay' => $days_between,
                'total_attended_days' => $totalPresentDays,
                'total_nonattended_days' => $tStayDaywithoutAtten,
                'daily_allowance_for_attended_days' => $request->daily_present_allow_in_edit_page,
                'daily_allowance_for_nonattended_days' => $request->daily_travel_allow_in_edit_page,
                'transport_allowance_for_attended_days' => $request->daily_present_travel_allow_in_edit_page,
                'transport_allowance_for_nonattended_days' => $request->daily_travel_stay_allow_in_edit_page,
                'total_daily_allowance_for_attended_days' => $tDailyPresentAllow,
                'total_daily_allowance_for_nonattended_days' => $tDailyStayAllow,
                'total_transport_allowance_for_attended_days' => $tDailyPresentTravelAllow,
                'total_transport_allowance_for_nonattended_days' => $tDailyStayTravelAllow,
                'created_at' => Carbon::now()->format('d-m-Y')
            ]);
            DB::commit();
            if ($sts) {
                return redirect(route('admin.travel_allowance.travelAllowanceBill.edit', $billId))->with('success', 'Bill Created Successfully');
            } else {
                return redirect(route('admin.travel_allowance.travelAllowanceBill.edit', $billId))->with('error', 'Bill Not Created Successfully');
            }
        } catch (\Throwable $e) {
            dd($e);
            $errorMessage = $e->getMessage();
            $customMessage = "Exception! Something went wrong please try again!";

            Session::flash('error', $customMessage, true);
            return response()->json(['status' => 'error']);
        }
    }
}
