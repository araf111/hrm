<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    }

    public function sendSMS(Request $request)
    {
        $endpoint  = "http://bulksms.teletalk.com.bd/link_sms_send.php";
        $mobile_no = $request->mobile_no;
        $sms_body =  $request->sms_body;
        $sms_user   = "dhakawasa";
        $sms_pass    = 'dhakAwasAo123';
        $sms_op = 'SMS';

        $response = Http::withHeaders([
            //'token' => $prp_token,
        ])->get($endpoint, [
            'user' => $sms_user,
            'pass'  => $sms_pass,
            'charset' => 'ASCII',
            'op' => $sms_op,
            'mobile' => $mobile_no,
            'sms' => $sms_body
        ]);

        $statusCode = $response->getStatusCode();
        $content    = $response->getBody();
        $sms_response = explode(',',$content);
        if(count($sms_response)>0 && $sms_response[0]=='<reply>SUCCESS'){
            return true;
        }
        else{
            return false;
        }
        //SUCCESS,ID=A1631105798902300107XTCW,PREVIOUS CREDIT=1731918,CURRENT CREDIT=1731917.00,DEDUCTED CREDIT=1,TOTAL CHAR=8,SERVER=bulksms.teletalk.com.bd,SMS CLASS=GENERAL
        //FAILED,INVALID NUMBER
    }
}
