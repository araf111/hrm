<?php

namespace App\Model\SSO\Lib;

use App\Model\SSO\AppLogoutRequest;
use App\Model\SSO\Lib\Interfaces\ISSOLogout;
use Illuminate\Http\Request;

class SSOLogout implements ISSOLogout
{
    public function __construct()
    {
    }

    public function getRedirectUrl(Request $request)
    {
        $request->session()->forget(LibConstants::USER_FULL_NAME);
        $request->session()->forget(LibConstants::SSO_DESIGNATION);
        $request->session()->forget(LibConstants::USER_SESSION_KEY);
        $request->session()->forget(LibConstants::TOKEN_VALIDITY_TIME);
        $request->session()->forget(LibConstants::API_ACCESS_TOKEN_VALIDITY_TIME);

        $appLogoutRequest = new AppLogoutRequest();
        $requestUrl = $appLogoutRequest->buildRequest();

        return $requestUrl;
    }
}