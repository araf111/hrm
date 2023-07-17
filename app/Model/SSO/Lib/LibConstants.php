<?php

namespace App\Model\SSO\Lib;

use DateTime;
use DateTimeZone;
use Exception;

class LibConstants
{
    const NONCE = 'nonce';
    const TOKEN = 'token';
    const TOKEN_VALIDITY_TIME = 'validity';
    const USER_FULL_NAME = '"user_full_name"';
    const SSO_DESIGNATION = 'sso-designation';
    const USER_SESSION_KEY = 'user_session_key';
    const API_ACCESS_TOKEN = 'api-access-token';
    const API_ACCESS_TOKEN_VALIDITY_TIME = 'api-access-token-validity-time';

    const CREATE_TOKEN_URL = "http://esb.beta.doptor.gov.bd:8280/token/create";
    const WIDGET_URL = "http://esb.beta.doptor.gov.bd:8280/identity/designation/%s/apps";
    const EMPLOYEE_DETAILS_URL = "http://esb.beta.doptor.gov.bd:8280/employee/details/%s";
    
    public static function getCurrentUTCTime()
    {
        try {
            $time = new DateTime("now", new DateTimeZone("UTC"));
            return $time->getTimestamp();
        } catch (Exception $e) {
            return 0;
        }
    }
}