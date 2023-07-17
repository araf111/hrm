<?php

namespace App\Model\SSO\Lib;

use App\Model\SSO\AppLoginRequest;
use App\Model\SSO\AppLoginResponse;
use App\Model\SSO\Lib\Interfaces\ISSOLogin;
use App\Model\SSO\SSOConstants;
use Exception;
use Illuminate\Http\Request;

class SSOLogin implements ISSOLogin
{
    public function __construct()
    {
    }

    public function getRedirectUrl(Request $request)
    {
        $userSessionKey = $request->session()->get(LibConstants::USER_SESSION_KEY);
        if ($userSessionKey != null && $this->isUserAlreadyLogin($request) != null) {
            return SSOConstants::LANDING_PAGE_URI;
        }

        $appLoginRequest = new AppLoginRequest();
        $requestUrl = $appLoginRequest->buildRequest();
        $nonce = $appLoginRequest->getReqNonce();
        $request->session()->put(LibConstants::NONCE, $nonce);

        return $requestUrl;
    }

    private function isUserAlreadyLogin(Request $request)
    {
        $nonce = $request->session()->get(LibConstants::NONCE);
        $token = $request->session()->get(LibConstants::USER_SESSION_KEY);

        $appLoginResponse = new AppLoginResponse();
        try {
            $response = $appLoginResponse->parseResponse($token, $nonce);
            return $response;
        } catch (Exception $e) {
            return null;
        }
    }
}