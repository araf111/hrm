<?php

namespace App\Model\SSO\Lib;

use App\Model\SSO\AppLoginResponse;
use App\Model\SSO\AppLoginResponseDTO;
use App\Model\SSO\Lib\Interfaces\IHome;
use Exception;
use Illuminate\Http\Request;

class Home implements IHome
{
    private $userFullName;

    public function __construct()
    {
    }

    public function getUserData(Request $request)
    {
        try {
            if (($response = $this->isUserAlreadyLogin($request)) != null) {
                $this->userFullName = $this->getUserName($request, $response);
                return $response;
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    private function isUserAlreadyLogin(Request $request)
    {
        $nonce = $request->session()->get(LibConstants::NONCE);
        $token = $request->session()->get(LibConstants::USER_SESSION_KEY);

        if ($nonce == null || $token == null) return null;

        $appLoginResponse = new AppLoginResponse();
        try {
            $response = $appLoginResponse->parseResponse($token, $nonce);
            return $response;
        } catch (Exception $e) {
            return null;
        }
    }

    private function getUserName(Request $request, AppLoginResponseDTO $appLoginResponseDTO)
    {
        if (($userName = $request->session()->get(LibConstants::USER_FULL_NAME)) != null) {
            return $userName;
        }

        $httpRequest = new SSOHttpRequest();
        $userInfoDTO = $httpRequest->getUserDetails($request, $appLoginResponseDTO->getUserName());

        $request->session()->put(LibConstants::USER_FULL_NAME, $userInfoDTO->getNameBng());
        return $userInfoDTO->getNameBng();
    }

    public function getUserFullName()
    {
        return $this->userFullName;
    }
}