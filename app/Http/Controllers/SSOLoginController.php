<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Model\SSO\Lib\SSOLogin;
use App\Model\SSO\Lib\SSOAppLogin;
use App\Model\SSO\Lib\SSOLogout;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Backend\ProfileActivities\V2ProfileController;
use App\Http\PostCallerClass;
use App\Http\Controllers\Auth\LoginController;

class SSOLoginController extends Controller
{
    public function ssologin(Request $request)
    {

        $iSSOLogin = new SSOLogin();
        $url = $iSSOLogin->getRedirectUrl($request);
       //dd($url);
        return Redirect::to($url);
    }

    public function applogin(Request $request)
    {
        
        //dd(json_decode($request['ssoResponse'],true));
        //die();
        try {
            //dd($request->all());

            /* $sso_prorileID = '0110011';
            $existing_profile = DB::select('select p.profileID,p.user_id,u.email,u.password from v2_profiles p left join users u on u.id = p.user_id where p.profileID='.$sso_prorileID);
            if(count($existing_profile)>0){
                $email = $existing_profile[0]->email;
                $password = $existing_profile[0]->password;

                $post = new PostCallerClass(
                    LoginController::class,
                    'login',
                    Request::class,
                    [
                        'email'=>$email,
                        'password'=>$password,
                    ]
                );

                if($post){
                   return view('backend.dashboard.mp_dashboard');
                }
            } */


            $iSSOAppLogin = new SSOAppLogin();
            //return $iSSOAppLogin->getLandingUrl($request);
            return Redirect::to($iSSOAppLogin->getLandingUrl($request));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ssologout(Request $request)
    {
        $iSSOLogout = new SSOLogout();
        return Redirect::to($iSSOLogout->getRedirectUrl($request));
    }
}