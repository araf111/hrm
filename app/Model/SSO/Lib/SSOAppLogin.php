<?php


namespace App\Model\SSO\Lib;

use App\Model\SSO\AppLoginResponse;
use App\Model\SSO\Lib\Interfaces\ISSOAppLogin;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Http\Request;

class SSOAppLogin implements ISSOAppLogin
{
    public function __construct()
    {
    }

    public function getLandingUrl(Request $request)
    {
        try {
            $token = $request->input(LibConstants::TOKEN);
            //$nonce = $request->session()->get(LibConstants::NONCE);
            $nonce = $request->input(LibConstants::NONCE);
            $appLoginResponse = new AppLoginResponse();
            $response = $appLoginResponse->parseResponse($token, $nonce);
            //dd(LibConstants::USER_SESSION_KEY);
            //$request->session()->put(LibConstants::USER_SESSION_KEY, $token);
            //$request->session()->put(LibConstants::SSO_DESIGNATION, $response->getOfficeUnitOrganogramId());
            //dd($response);
            return $response->getLandingPageUrl();
        } catch (Exception $e) {
            dd($e);
            return new Exception();
        }
    }
}