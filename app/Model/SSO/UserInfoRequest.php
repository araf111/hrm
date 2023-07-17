<?php


namespace App\Model\SSO;


class UserInfoRequest
{
    private $userDetailsUrl = 'http://esb.beta.doptor.gov.bd:8280/employee/details/%s';

    public function __construct()
    {
    }

    public function getUserInformation($userId)
    {
        $widget = new Widget();
        $token = $widget->getToken();
        $arr = json_decode($token, true);

        $headers = array(
            "Authorization: Bearer " . $arr['token'],
            "Content-Type: application/json"
        );

        $url = sprintf($this->userDetailsUrl, $userId);

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }
}