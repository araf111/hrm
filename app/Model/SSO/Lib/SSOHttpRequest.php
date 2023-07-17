<?php

namespace App\Model\SSO\Lib;

use App\Model\SSO\SSOConstants;
use Illuminate\Http\Request;

class SSOHttpRequest
{
    public function __construct()
    {
    }

    public function getWidgetList(Request $request)
    {
        $token = $this->getSecretKey($request);
        $designation = $this->getDesignation($request);

        $headers = array(
            "Authorization: Bearer " . $token,
            "Content-Type: application/json"
        );
        $url = sprintf(LibConstants::WIDGET_URL, $designation);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);
        curl_close($curl);

        return response()->json($result, 200);
    }

    public function getUserDetails(Request $request, $userId)
    {
        $token = $this->getSecretKey($request);
        $headers = array(
            "Authorization: Bearer " . $token,
            "Content-Type: application/json"
        );
        $url = sprintf(LibConstants::EMPLOYEE_DETAILS_URL, $userId);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);
        curl_close($curl);

        $userInformationDTO = UserInformationDTO::parseJSON(json_decode($result, true));
        return $userInformationDTO;
    }

    private function getSecretKey(Request $request)
    {
        if (($token = $this->hasApiAccessToken($request)) != null) return $token;

        $ch = curl_init(LibConstants::CREATE_TOKEN_URL);
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_AUTOREFERER => true,
            CURLOPT_CONNECTTIMEOUT => 20,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_POST => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_VERBOSE => 1,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Secret " . SSOConstants::SHARED_SECRET,
                "Content-Type: application/json"
            )
        );

        curl_setopt_array($ch, $options);
        $data = curl_exec($ch);
        curl_close($ch);

        $arr = json_decode($data, true);
        $request->session()->put(LibConstants::API_ACCESS_TOKEN, $arr[LibConstants::TOKEN]);
        $request->session()->put(LibConstants::API_ACCESS_TOKEN_VALIDITY_TIME, $arr[LibConstants::TOKEN_VALIDITY_TIME] + LibConstants::getCurrentUTCTime());
        return $arr[LibConstants::TOKEN];
    }

    private function hasApiAccessToken(Request $request)
    {
        if (($validity = $request->session()->get(LibConstants::API_ACCESS_TOKEN_VALIDITY_TIME)) != null) {
            if ($validity <= LibConstants::getCurrentUTCTime()) return null;
        }
        $token = ($request->session()->get(LibConstants::API_ACCESS_TOKEN));
        return $token;
    }

    private function getDesignation(Request $request)
    {
        if ($designation = ($request->session()->get(LibConstants::SSO_DESIGNATION)) != null) {
            return $designation;
        }
        return null;
    }
}